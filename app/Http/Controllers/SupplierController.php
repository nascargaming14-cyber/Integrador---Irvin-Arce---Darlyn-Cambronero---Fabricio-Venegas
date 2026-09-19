<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SupplierController extends Controller
{
    /**
     * Lista todos los proveedores con su estado.
     */
    public function index(): View
    {
        $suppliers = Supplier::with('status')
            ->orderBy('id')
            ->paginate(10);

        return view('suppliers.index', compact('suppliers'));
    }

    /**
     * Muestra el formulario para crear un nuevo proveedor.
     */
    public function create(): View
    {
        $statuses = Status::whereIn('status_name', [
            'Activo', 'Inactivo', 'Eliminado',
        ])->orderBy('status_name')->get();

        return view('suppliers.create', compact('statuses'));
    }

    /**
     * Crea un nuevo proveedor.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:150',
            'status_id' => 'required|integer|exists:status,id',
        ]);

        Supplier::create($validated);

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Proveedor creado exitosamente.');
    }

    /**
     * Muestra un proveedor con su estado y productos asociados.
     */
    public function show(string $id): View
    {
        $supplier = Supplier::with(['status', 'products.status'])->findOrFail($id);

        return view('suppliers.show', compact('supplier'));
    }

    /**
     * Muestra el formulario para editar un proveedor existente.
     */
    public function edit(string $id): View
    {
        $supplier = Supplier::findOrFail($id);
        $statuses = Status::whereIn('status_name', [
            'Activo', 'Inactivo', 'Eliminado',
        ])->orderBy('status_name')->get();

        return view('suppliers.edit', compact('supplier', 'statuses'));
    }

    /**
     * Actualiza un proveedor existente.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $supplier = Supplier::findOrFail($id);

        $validated = $request->validate([
            'name'      => 'required|string|max:150',
            'status_id' => 'required|integer|exists:status,id',
        ]);

        $supplier->update($validated);

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Proveedor actualizado exitosamente.');
    }

    /**
     * Elimina un proveedor.
     */
    public function destroy(string $id): RedirectResponse
    {
        $supplier = Supplier::findOrFail($id);

        try {
            $supplier->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()
                ->route('suppliers.index')
                ->with('error', 'No se puede eliminar el proveedor porque tiene productos asociados.');
        }

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Proveedor eliminado exitosamente.');
    }
}
