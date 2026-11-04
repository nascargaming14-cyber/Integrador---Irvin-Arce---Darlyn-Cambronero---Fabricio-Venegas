<?php

namespace App\Http\Controllers;

use App\Models\CalendarJob;
use App\Models\Crew;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class CalendarController extends Controller
{
    /**
     * Vista mensual de la pizarra: una fila por semana, y dentro
     * de cada día una casilla por cuadrilla con su trabajo (si tiene).
     */
    public function index(Request $request): View
    {
        $month = $request->input('month', now()->format('Y-m'));
        $start = Carbon::parse($month . '-01')->startOfMonth();
        $end   = $start->copy()->endOfMonth();

        $crews = Crew::where('active', true)->orderBy('sort_order')->get();

        $jobs = CalendarJob::with(['crew', 'product', 'confirmedBy'])
            ->whereBetween('work_date', [$start->toDateString(), $end->toDateString()])
            ->get()
            ->groupBy(fn ($job) => $job->work_date->toDateString());

        // Agente(s) para el cuadro de Confirmación:
        // el Administrador puede elegir entre todos; cualquier otro rol solo se confirma a sí mismo.
        /** @var \App\Models\User $currentUser */
        /** @disregard P1013 */
        $currentUser = auth()->user();
        $isAdmin = optional($currentUser->role)->role_name === 'Administrador';
        $agents  = $isAdmin ? User::orderBy('user_name')->get() : collect([$currentUser]);

        // Productos guardados, para el combo de "Material" (con su unidad de medida)
        $products = Product::with('unitMeasurement')->orderBy('product_name')->get();

        // Cuadrícula de semanas completas (lunes a domingo) que cubren el mes
        $gridStart = $start->copy()->startOfWeek(Carbon::MONDAY);
        $gridEnd   = $end->copy()->endOfWeek(Carbon::MONDAY);

        $weeks   = [];
        $cursor  = $gridStart->copy();
        while ($cursor->lte($gridEnd)) {
            $week = [];
            for ($i = 0; $i < 7; $i++) {
                $week[] = $cursor->copy();
                $cursor->addDay();
            }
            $weeks[] = $week;
        }

        return view('calendar.index', compact('crews', 'jobs', 'agents', 'products', 'start', 'end', 'month', 'weeks', 'isAdmin'));
    }

    /**
     * Asigna un trabajo nuevo a una cuadrilla en una fecha específica.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'crew_id'     => 'required|integer|exists:crews,id',
            'work_date'   => 'required|date',
            'client_name' => 'required|string|max:150',
            'location'    => 'nullable|string|max:150',
            'area_m2'     => 'nullable|numeric|min:0',
            'product_id'  => 'nullable|integer|exists:products,id',
            'notes'       => 'nullable|string',
        ]);

        // Una cuadrilla solo puede tener un trabajo por día (ver migración: unique crew_id+work_date)
        $exists = CalendarJob::where('crew_id', $validated['crew_id'])
            ->where('work_date', $validated['work_date'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'Esa cuadrilla ya tiene un trabajo asignado ese día.');
        }

        DB::transaction(function () use ($validated) {
            // Pendiente por defecto: se rebaja de una vez; se devuelve solo si luego se marca "No completado"
            $willDeductStock = false;

            if (!empty($validated['product_id']) && !empty($validated['area_m2'])) {
                $product = Product::find($validated['product_id']);
                if ($product) {
                    $product->decrement('stock', $validated['area_m2']);
                    $willDeductStock = true;
                }
            }

            $validated['stock_deducted'] = $willDeductStock;

            CalendarJob::create($validated);
        });

        return redirect()
            ->route('calendar.index', ['month' => Carbon::parse($validated['work_date'])->format('Y-m')])
            ->with('success', 'Trabajo asignado exitosamente.');
    }

    /**
     * Edita los datos de un trabajo existente.
     */
    public function update(Request $request, CalendarJob $calendarJob): RedirectResponse
    {
        // Si el agente ya confirmó Y el trabajo quedó completado, ya no se puede tocar nada.
        if ($calendarJob->confirmed && $calendarJob->completed === true) {
            return back()->with('error', 'Este trabajo ya está confirmado y completado; no se puede editar.');
        }

        $validated = $request->validate([
            'client_name'  => 'required|string|max:150',
            'location'     => 'nullable|string|max:150',
            'area_m2'      => 'nullable|numeric|min:0',
            'product_id'   => 'nullable|integer|exists:products,id',
            'notes'        => 'nullable|string',
            'move_to_date' => 'nullable|date',
        ]);

        // Mover el trabajo a otro día: se valida que la cuadrilla esté libre ese día.
        $moveToDate = $validated['move_to_date'] ?? null;
        unset($validated['move_to_date']);

        if ($moveToDate && $moveToDate !== $calendarJob->work_date->toDateString()) {
            $conflict = CalendarJob::where('crew_id', $calendarJob->crew_id)
                ->where('work_date', $moveToDate)
                ->where('id', '!=', $calendarJob->id)
                ->exists();

            if ($conflict) {
                return back()->with('error', 'Esa cuadrilla ya tiene un trabajo asignado ese día. No se pudo mover.');
            }

            $validated['work_date'] = $moveToDate;
        }

        DB::transaction(function () use ($calendarJob, $validated) {
            // Si ya tenía stock rebajado, primero se le devuelve al producto/cantidad viejos
            if ($calendarJob->stock_deducted && $calendarJob->product_id && $calendarJob->area_m2) {
                $oldProduct = Product::find($calendarJob->product_id);
                if ($oldProduct) {
                    $oldProduct->increment('stock', $calendarJob->area_m2);
                }
            }

            $calendarJob->update($validated);

            // Si el trabajo no está cancelado ("No completado"), se vuelve a rebajar con los datos nuevos
            if ($calendarJob->completed !== false && $calendarJob->product_id && $calendarJob->area_m2) {
                $newProduct = Product::find($calendarJob->product_id);
                if ($newProduct) {
                    $newProduct->decrement('stock', $calendarJob->area_m2);
                }
                $calendarJob->stock_deducted = true;
            } else {
                $calendarJob->stock_deducted = false;
            }
            $calendarJob->save();
        });

        return redirect()
            ->route('calendar.index', ['month' => $calendarJob->work_date->format('Y-m')])
            ->with('success', 'Trabajo actualizado exitosamente.');
    }

    /**
     * Marca un trabajo como completado, no completado, o lo regresa a pendiente.
     * (El checkbox verde/rojo de la pizarra.)
     */
    public function updateStatus(Request $request, CalendarJob $calendarJob): RedirectResponse
    {
        if ($calendarJob->confirmed && $calendarJob->completed === true) {
            return back()->with('error', 'Este trabajo ya está confirmado y completado; no se puede modificar.');
        }

        $validated = $request->validate([
            // 1 = completado, 0 = no completado, vacío/ausente = pendiente
            'completed' => 'nullable|boolean',
        ]);

        $newCompleted = $validated['completed'] ?? null;

        if ($newCompleted === true && ! $calendarJob->confirmed) {
            return back()->with('error', 'Primero debes confirmar el trabajo (cuadro de Confirmación) antes de marcarlo como Completado.');
        }

        DB::transaction(function () use ($calendarJob, $newCompleted) {
            // Se marca "No completado" (cancelado) y ya tenía stock rebajado: se devuelve.
            $isCancelling = ($newCompleted === false) && $calendarJob->stock_deducted;

            // Se marca Pendiente o Completado y NO tenía stock rebajado (venía cancelado): se vuelve a rebajar.
            $isReactivating = ($newCompleted !== false) && ! $calendarJob->stock_deducted
                && $calendarJob->product_id && $calendarJob->area_m2;

            if ($isCancelling) {
                $product = Product::find($calendarJob->product_id);
                if ($product) {
                    $product->increment('stock', $calendarJob->area_m2);
                }
                $calendarJob->stock_deducted = false;
            } elseif ($isReactivating) {
                $product = Product::find($calendarJob->product_id);
                if ($product) {
                    $product->decrement('stock', $calendarJob->area_m2);
                }
                $calendarJob->stock_deducted = true;
            }

            $calendarJob->completed = $newCompleted;
            $calendarJob->save();
        });

        return back()->with('success', 'Estado actualizado.');
    }

    /**
     * Cuadro de Confirmación: valida el PIN del agente seleccionado
     * y registra si el proyecto/cambio quedó confirmado.
     */
    public function confirm(Request $request, CalendarJob $calendarJob): RedirectResponse
    {
        if ($calendarJob->confirmed && $calendarJob->completed === true) {
            return back()->with('error', 'Este trabajo ya está confirmado y completado; no se puede modificar.');
        }

        $validated = $request->validate([
            'confirmed' => 'required|boolean',
            'agent_id'  => 'required|integer|exists:users,id',
            'pin'       => 'required|digits:4',
        ]);

        $agent = User::findOrFail($validated['agent_id']);

        if (! $agent->pin || ! Hash::check($validated['pin'], $agent->pin)) {
            return back()->with('error', 'PIN incorrecto para el agente seleccionado.');
        }

        $calendarJob->update([
            'confirmed'    => $validated['confirmed'],
            'confirmed_by' => $agent->id,
            'confirmed_at' => now(),
        ]);

        return back()->with('success', 'Confirmación registrada exitosamente.');
    }

    /**
     * Elimina un trabajo de la pizarra. Si ya se había descontado stock
     * (trabajo confirmado), se le devuelve el producto antes de borrarlo.
     */
    public function destroy(CalendarJob $calendarJob): RedirectResponse
    {
        if ($calendarJob->confirmed && $calendarJob->completed === true) {
            return back()->with('error', 'Este trabajo ya está confirmado y completado; no se puede eliminar.');
        }

        $month = $calendarJob->work_date->format('Y-m');

        if ($calendarJob->stock_deducted && $calendarJob->product_id) {
            $product = Product::find($calendarJob->product_id);
            if ($product) {
                $product->increment('stock', $calendarJob->area_m2);
            }
        }

        $calendarJob->delete();

        return redirect()
            ->route('calendar.index', ['month' => $month])
            ->with('success', 'Trabajo eliminado exitosamente.');
    }
}
