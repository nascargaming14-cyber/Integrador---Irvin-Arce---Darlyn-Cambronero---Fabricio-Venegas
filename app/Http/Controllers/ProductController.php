<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Status;
use App\Models\SubCategory;
use App\Models\UnitMeasurement;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Lista productos con búsqueda por nombre/código de barras
     * y filtros por categoría y proveedor.
     */
    public function index(Request $request): View
    {
        $query = Product::with([
            'subCategory.category',
            'unitMeasurement',
            'status',
            'suppliers',
        ]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('product_name', 'like', "%{$search}%")
                  ->orWhere('barcode', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $categoryId = $request->category_id;
            $query->whereHas('subCategory', function ($q) use ($categoryId) {
                $q->where('category_id', $categoryId);
            });
        }

        if ($request->filled('supplier_id')) {
            $supplierId = $request->supplier_id;
            $query->whereHas('suppliers', function ($q) use ($supplierId) {
                $q->where('suppliers.id', $supplierId);
            });
        }

        $products = $query->orderBy('id')->paginate(10)->withQueryString();

        $categories = Category::orderBy('category_name')->get();
        $suppliers  = Supplier::whereHas('status', function ($q) {
            $q->where('status_name', 'Activo');
        })->orderBy('name')->get();

        return view('products.index', compact('products', 'categories', 'suppliers'));
    }

    /**
     * Muestra el formulario para crear un nuevo producto.
     */
    public function create(): View
    {
        $categories    = Category::orderBy('category_name')->get();
        $subCategories = SubCategory::with('category')->orderBy('subcategory_name')->get();
        $units         = UnitMeasurement::orderBy('unit_name')->get();
        $statuses      = Status::whereIn('status_name', [
            'Activo', 'Inactivo', 'Agotado', 'Disponible', 'Descontinuado', 'Eliminado',
        ])->orderBy('status_name')->get();
        $suppliers     = Supplier::whereHas('status', function ($q) {
            $q->where('status_name', 'Activo');
        })->orderBy('name')->get();

        $subCategoryUnits = SubCategory::with('allowedUnits')->get()
            ->mapWithKeys(fn ($sub) => [$sub->id => $sub->allowedUnits->pluck('id')]);

        return view('products.create', compact('categories', 'subCategories', 'units', 'statuses', 'subCategoryUnits', 'suppliers'));
    }

    /**
     * Crea un nuevo producto y asocia sus proveedores.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'barcode'         => 'required|string|max:100|unique:products,barcode',
            'product_name'    => 'required|string|max:150',
            'stock'           => 'nullable|numeric|min:0',
            'minimum_stock'   => 'nullable|numeric|min:0',
            'price_sale'      => 'required|numeric|min:0',
            'price_buy'       => 'required|numeric|min:0',
            'sub_category_id' => 'required|integer|exists:sub_categories,id',
            'unit_id'         => 'required|integer|exists:unit_measurement,id',
            'status_id'       => 'required|integer|exists:status,id',
            'supplier_ids'    => 'nullable|array',
            'supplier_ids.*'  => 'integer|exists:suppliers,id',
        ]);

        $product = Product::create(collect($validated)->except('supplier_ids')->toArray());

        $this->syncSuppliers($product, $validated['supplier_ids'] ?? [], $validated['status_id']);

        return redirect()
            ->route('products.index')
            ->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Muestra un producto con todas sus relaciones.
     */
    public function show(string $id): View
    {
        $product = Product::with([
            'subCategory.category',
            'unitMeasurement',
            'status',
            'suppliers',
        ])->findOrFail($id);

        return view('products.show', compact('product'));
    }

    /**
     * Muestra el formulario para editar un producto existente.
     */
    public function edit(string $id): View
    {
        $product       = Product::with('suppliers')->findOrFail($id);
        $categories    = Category::orderBy('category_name')->get();
        $subCategories = SubCategory::with('category')->orderBy('subcategory_name')->get();
        $units         = UnitMeasurement::orderBy('unit_name')->get();
        $statuses      = Status::whereIn('status_name', [
            'Activo', 'Inactivo', 'Agotado', 'Disponible', 'Descontinuado', 'Eliminado',
        ])->orderBy('status_name')->get();
        $suppliers     = Supplier::whereHas('status', function ($q) {
            $q->where('status_name', 'Activo');
        })->orderBy('name')->get();

        $subCategoryUnits = SubCategory::with('allowedUnits')->get()
            ->mapWithKeys(fn ($sub) => [$sub->id => $sub->allowedUnits->pluck('id')]);

        return view('products.edit', compact('product', 'categories', 'subCategories', 'units', 'statuses', 'subCategoryUnits', 'suppliers'));
    }

    /**
     * Actualiza un producto existente y sincroniza sus proveedores.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'barcode'         => 'required|string|max:100|unique:products,barcode,' . $id,
            'product_name'    => 'required|string|max:150',
            'stock'           => 'nullable|numeric|min:0',
            'minimum_stock'   => 'nullable|numeric|min:0',
            'price_sale'      => 'required|numeric|min:0',
            'price_buy'       => 'required|numeric|min:0',
            'sub_category_id' => 'required|integer|exists:sub_categories,id',
            'unit_id'         => 'required|integer|exists:unit_measurement,id',
            'status_id'       => 'required|integer|exists:status,id',
            'supplier_ids'    => 'nullable|array',
            'supplier_ids.*'  => 'integer|exists:suppliers,id',
        ]);

        $product->update(collect($validated)->except('supplier_ids')->toArray());

        $this->syncSuppliers($product, $validated['supplier_ids'] ?? [], $validated['status_id']);

        return redirect()
            ->route('products.index')
            ->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Elimina un producto.
     */
    public function destroy(string $id): RedirectResponse
    {
        $product = Product::findOrFail($id);

        try {
            $product->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()
                ->route('products.index')
                ->with('error', 'No se puede eliminar el producto porque tiene movimientos o proveedores asociados.');
        }

        return redirect()
            ->route('products.index')
            ->with('success', 'Producto eliminado exitosamente.');
    }

    /**
     * Sincroniza los proveedores seleccionados para un producto,
     * respetando que la tabla pivote requiere status_id.
     */
    private function syncSuppliers(Product $product, array $supplierIds, int $statusId): void
    {
        $syncData = collect($supplierIds)->mapWithKeys(function ($supplierId) use ($statusId) {
            return [$supplierId => ['status_id' => $statusId]];
        })->toArray();

        $product->suppliers()->sync($syncData);
    }
}
