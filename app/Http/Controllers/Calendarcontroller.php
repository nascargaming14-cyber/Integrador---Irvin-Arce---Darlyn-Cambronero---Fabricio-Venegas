<?php

namespace App\Http\Controllers;

use App\Models\CalendarJob;
use App\Models\Crew;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

        $jobs = CalendarJob::with(['crew', 'confirmedBy'])
            ->whereBetween('work_date', [$start->toDateString(), $end->toDateString()])
            ->get()
            ->groupBy(fn ($job) => $job->work_date->toDateString());

        // Usuarios para el combo de "Agente" del cuadro de Confirmación
        $agents = User::orderBy('user_name')->get();

        // Productos guardados, para el combo de "Material"
        $products = Product::orderBy('product_name')->get();

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

        return view('calendar.index', compact('crews', 'jobs', 'agents', 'products', 'start', 'end', 'month', 'weeks'));
    }

    /**
     * Asigna un trabajo nuevo a una cuadrilla en una fecha específica.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'crew_id'       => 'required|integer|exists:crews,id',
            'work_date'     => 'required|date',
            'client_name'   => 'required|string|max:150',
            'location'      => 'nullable|string|max:150',
            'area_m2'       => 'nullable|numeric|min:0',
            'material_type' => 'nullable|string|max:100',
            'notes'         => 'nullable|string',
        ]);

        // Una cuadrilla solo puede tener un trabajo por día (ver migración: unique crew_id+work_date)
        $exists = CalendarJob::where('crew_id', $validated['crew_id'])
            ->where('work_date', $validated['work_date'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'Esa cuadrilla ya tiene un trabajo asignado ese día.');
        }

        CalendarJob::create($validated);

        return redirect()
            ->route('calendar.index', ['month' => Carbon::parse($validated['work_date'])->format('Y-m')])
            ->with('success', 'Trabajo asignado exitosamente.');
    }

    /**
     * Edita los datos de un trabajo existente.
     */
    public function update(Request $request, CalendarJob $calendarJob): RedirectResponse
    {
        $validated = $request->validate([
            'client_name'   => 'required|string|max:150',
            'location'      => 'nullable|string|max:150',
            'area_m2'       => 'nullable|numeric|min:0',
            'material_type' => 'nullable|string|max:100',
            'notes'         => 'nullable|string',
        ]);

        $calendarJob->update($validated);

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
        $validated = $request->validate([
            // 1 = completado, 0 = no completado, vacío/ausente = pendiente
            'completed' => 'nullable|boolean',
        ]);

        $calendarJob->update(['completed' => $validated['completed'] ?? null]);

        return back()->with('success', 'Estado actualizado.');
    }

    /**
     * Cuadro de Confirmación: valida el PIN del agente seleccionado
     * y registra si el proyecto/cambio quedó confirmado.
     */
    public function confirm(Request $request, CalendarJob $calendarJob): RedirectResponse
    {
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
     * Elimina un trabajo de la pizarra.
     */
    public function destroy(CalendarJob $calendarJob): RedirectResponse
    {
        $month = $calendarJob->work_date->format('Y-m');
        $calendarJob->delete();

        return redirect()
            ->route('calendar.index', ['month' => $month])
            ->with('success', 'Trabajo eliminado exitosamente.');
    }
}
