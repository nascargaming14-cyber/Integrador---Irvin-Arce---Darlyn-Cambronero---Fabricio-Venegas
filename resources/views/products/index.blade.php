@extends('layouts.app')

@section('title', 'Productos')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-0" style="color:#1a1f2e">Productos</h2>
        <p class="text-muted small mb-0">Listado de todos los productos registrados</p>
    </div>
    <a href="{{ route('products.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Nuevo producto
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('products.index') }}" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label small text-muted mb-1">Buscar</label>
                <input type="text" name="search" class="form-control"
                       placeholder="Nombre o código de barras..."
                       value="{{ request('search') }}">
            </div>

            <div class="col-md-3">
                <label class="form-label small text-muted mb-1">Categoría</label>
                <select name="category_id" class="form-select">
                    <option value="">Todas las categorías</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label small text-muted mb-1">Proveedor</label>
                <select name="supplier_id" class="form-select">
                    <option value="">Todos los proveedores</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-fill">
                    <i class="bi bi-search"></i> Buscar
                </button>
                @if(request()->hasAny(['search', 'category_id', 'supplier_id']))
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary" title="Limpiar filtros">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th class="ps-4">#</th>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Stock</th>
                    <th>Precio venta</th>
                    <th>Estado</th>
                    <th class="text-end pe-4">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td class="ps-4">{{ $product->id }}</td>
                        <td>{{ $product->barcode }}</td>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->subCategory->subcategory_name ?? '—' }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>₡{{ number_format($product->price_sale, 2) }}</td>
                        <td>{{ $product->status->status_name ?? '—' }}</td>
                        <td class="text-end pe-4">
                            <a href="{{ route('products.edit', $product->id) }}"
                               class="btn btn-sm btn-outline-secondary me-1" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('products.destroy', $product->id) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('¿Eliminar este producto?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            No se encontraron productos
                            @if(request()->hasAny(['search', 'category_id', 'supplier_id']))
                                con esos filtros.
                            @else
                                registrados.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $products->links('pagination::bootstrap-5') }}
</div>

@endsection
