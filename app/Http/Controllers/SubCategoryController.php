<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Status;
use App\Models\SubCategory;
use App\Models\UnitMeasurement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubCategoryController extends Controller
{
    /**
     * Lista todas las subcategorías con su categoría y estado.
     */
    public function index(): View
    {
        $subCategories = SubCategory::with(['category', 'status'])
            ->orderBy('subcategory_name')
            ->paginate(10);

        return view('subcategories.index', compact('subCategories'));
    }

    /**
     * Muestra el formulario para crear una nueva subcategoría.
     */
    public function create(): View
    {
        $categories = Category::orderBy('category_name')->get();
        $units      = UnitMeasurement::orderBy('unit_name')->get();
        $statuses   = Status::whereIn('status_name', [
            'Activo', 'Inactivo', 'Eliminado',
        ])->orderBy('status_name')->get();

        return view('subcategories.create', compact('categories', 'units', 'statuses'));
    }

    /**
     * Crea una nueva subcategoría asociada a una categoría y a las
     * unidades de medida que se le permiten a sus productos.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'subcategory_name' => 'required|string|max:100',
            'category_id'      => 'required|integer|exists:categories,id',
            'status_id'        => 'required|integer|exists:status,id',
            'unit_ids'         => 'nullable|array',
            'unit_ids.*'       => 'integer|exists:unit_measurement,id',
        ]);

        $subCategory = SubCategory::create(collect($validated)->except('unit_ids')->toArray());
        $subCategory->allowedUnits()->sync($validated['unit_ids'] ?? []);

        return redirect()
            ->route('subcategories.index')
            ->with('success', 'Subcategoría creada exitosamente.');
    }

    /**
     * Muestra una subcategoría con su categoría, estado y productos.
     */
    public function show(string $id): View
    {
        $subCategory = SubCategory::with(['category', 'status', 'products', 'allowedUnits'])
            ->findOrFail($id);

        return view('subcategories.show', compact('subCategory'));
    }

    /**
     * Muestra el formulario para editar una subcategoría existente.
     */
    public function edit(string $id): View
    {
        $subCategory = SubCategory::with('allowedUnits')->findOrFail($id);
        $categories  = Category::orderBy('category_name')->get();
        $units       = UnitMeasurement::orderBy('unit_name')->get();
        $statuses    = Status::whereIn('status_name', [
            'Activo', 'Inactivo', 'Eliminado',
        ])->orderBy('status_name')->get();

        return view('subcategories.edit', compact('subCategory', 'categories', 'units', 'statuses'));
    }

    /**
     * Actualiza una subcategoría existente y sincroniza sus
     * unidades de medida permitidas.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $subCategory = SubCategory::findOrFail($id);

        $validated = $request->validate([
            'subcategory_name' => 'required|string|max:100',
            'category_id'      => 'required|integer|exists:categories,id',
            'status_id'        => 'required|integer|exists:status,id',
            'unit_ids'         => 'nullable|array',
            'unit_ids.*'       => 'integer|exists:unit_measurement,id',
        ]);

        $subCategory->update(collect($validated)->except('unit_ids')->toArray());
        $subCategory->allowedUnits()->sync($validated['unit_ids'] ?? []);

        return redirect()
            ->route('subcategories.index')
            ->with('success', 'Subcategoría actualizada exitosamente.');
    }

    /**
     * Elimina una subcategoría.
     */
    public function destroy(string $id): RedirectResponse
    {
        $subCategory = SubCategory::findOrFail($id);

        try {
            $subCategory->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()
                ->route('subcategories.index')
                ->with('error', 'No se puede eliminar la subcategoría porque tiene productos asociados.');
        }

        return redirect()
            ->route('subcategories.index')
            ->with('success', 'Subcategoría eliminada exitosamente.');
    }
}
