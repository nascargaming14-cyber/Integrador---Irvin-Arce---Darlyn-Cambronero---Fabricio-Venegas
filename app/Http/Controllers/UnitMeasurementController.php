<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\UnitMeasurement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UnitMeasurementController extends Controller
{
    /**
     * Lista todas las unidades de medida con su estado.
     */
    public function index(): View
    {
        $units = UnitMeasurement::with('status')
            ->orderBy('unit_name')
            ->paginate(10);

        return view('units.index', compact('units'));
    }

    /**
     * Muestra el formulario para crear una nueva unidad de medida.
     */
    public function create(): View
    {
        $statuses = Status::whereIn('status_name', [
            'Activo', 'Inactivo', 'Eliminado',
        ])->orderBy('status_name')->get();

        return view('units.create', compact('statuses'));
    }

    /**
     * Crea una nueva unidad de medida.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'unit_name' => 'required|string|max:50|unique:unit_measurement,unit_name',
            'status_id' => 'required|integer|exists:status,id',
        ]);

        UnitMeasurement::create($validated);

        return redirect()
            ->route('units.index')
            ->with('success', 'Unidad de medida creada exitosamente.');
    }

    /**
     * Muestra una unidad de medida con su estado y productos asociados.
     */
    public function show(string $id): View
    {
        $unit = UnitMeasurement::with(['status', 'products'])->findOrFail($id);

        return view('units.show', compact('unit'));
    }

    /**
     * Muestra el formulario para editar una unidad de medida existente.
     */
    public function edit(string $id): View
    {
        $unit = UnitMeasurement::findOrFail($id);
        $statuses = Status::whereIn('status_name', [
            'Activo', 'Inactivo', 'Eliminado',
        ])->orderBy('status_name')->get();

        return view('units.edit', compact('unit', 'statuses'));
    }

    /**
     * Actualiza una unidad de medida existente.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $unit = UnitMeasurement::findOrFail($id);

        $validated = $request->validate([
            'unit_name' => 'required|string|max:50|unique:unit_measurement,unit_name,' . $id,
            'status_id' => 'required|integer|exists:status,id',
        ]);

        $unit->update($validated);

        return redirect()
            ->route('units.index')
            ->with('success', 'Unidad de medida actualizada exitosamente.');
    }

    /**
     * Elimina una unidad de medida.
     */
    public function destroy(string $id): RedirectResponse
    {
        $unit = UnitMeasurement::findOrFail($id);

        try {
            $unit->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()
                ->route('units.index')
                ->with('error', 'No se puede eliminar la unidad porque tiene productos o subcategorías asociadas.');
        }

        return redirect()
            ->route('units.index')
            ->with('success', 'Unidad de medida eliminada exitosamente.');
    }
}
