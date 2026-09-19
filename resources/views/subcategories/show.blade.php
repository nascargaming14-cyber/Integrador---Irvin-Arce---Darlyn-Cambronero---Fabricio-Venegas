@extends('layouts.app')

@section('title', 'Detalle de subcategoría')

@section('content')
    <div class="ac-page-head">
        <div>
            <h1>{{ $subCategory->subcategory_name }}</h1>
            <p>Detalle de la subcategoría y productos asociados.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('subcategories.edit', $subCategory->id) }}" class="btn btn-outline-primary">
                <i class="bi bi-pencil me-1"></i> Editar
            </a>
            <a href="{{ route('subcategories.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Volver
            </a>
        </div>
    </div>

    <div class="ac-card p-4 mb-4">
        <dl class="row mb-0">
            <dt class="col-sm-3 text-muted">Nombre</dt>
            <dd class="col-sm-9">{{ $subCategory->subcategory_name }}</dd>

            <dt class="col-sm-3 text-muted">Categoría</dt>
            <dd class="col-sm-9">{{ $subCategory->category->category_name ?? '—' }}</dd>

            <dt class="col-sm-3 text-muted">Estado</dt>
            <dd class="col-sm-9">{{ $subCategory->status->status_name ?? '—' }}</dd>
        </dl>
    </div>

    <div class="ac-card">
        <div class="p-3 border-bottom fw-semibold">Productos asociados ({{ $subCategory->products->count() }})</div>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Código</th>
                        <th>Producto</th>
                        <th>Stock</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($subCategory->products as $product)
                        <tr>
                            <td class="text-muted">{{ $product->id }}</td>
                            <td class="ac-mono">{{ $product->barcode }}</td>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>{{ $product->status->status_name ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-3">Sin productos asociados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
