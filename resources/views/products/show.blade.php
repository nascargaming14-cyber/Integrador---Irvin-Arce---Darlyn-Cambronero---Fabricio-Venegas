@extends('layouts.app')

@section('title', 'Detalle de producto')

@section('content')
    <div class="ac-page-head">
        <div>
            <h1>{{ $product->product_name }}</h1>
            <p>Detalle del producto.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-outline-primary">
                <i class="bi bi-pencil me-1"></i> Editar
            </a>
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Volver
            </a>
        </div>
    </div>

    <div class="ac-card p-4">
        <dl class="row mb-0">
            <dt class="col-sm-3 text-muted">Código de barras</dt>
            <dd class="col-sm-9 ac-mono">{{ $product->barcode }}</dd>

            <dt class="col-sm-3 text-muted">Nombre</dt>
            <dd class="col-sm-9">{{ $product->product_name }}</dd>

            <dt class="col-sm-3 text-muted">Categoría</dt>
            <dd class="col-sm-9">
                {{ $product->subCategory->category->category_name ?? '—' }} — {{ $product->subCategory->subcategory_name ?? '—' }}
            </dd>

            <dt class="col-sm-3 text-muted">Unidad de medida</dt>
            <dd class="col-sm-9">{{ $product->unitMeasurement->unit_name ?? '—' }}</dd>

            <dt class="col-sm-3 text-muted">Stock</dt>
            <dd class="col-sm-9">{{ $product->stock }} (mínimo: {{ $product->minimum_stock }})</dd>

            <dt class="col-sm-3 text-muted">Precio de compra</dt>
            <dd class="col-sm-9">₡{{ number_format($product->price_buy, 2) }}</dd>

            <dt class="col-sm-3 text-muted">Precio de venta</dt>
            <dd class="col-sm-9">₡{{ number_format($product->price_sale, 2) }}</dd>

            <dt class="col-sm-3 text-muted">Proveedores</dt>
            <dd class="col-sm-9">
                @forelse ($product->suppliers as $supplier)
                    <span class="badge bg-secondary me-1">{{ $supplier->name }}</span>
                @empty
                    <span class="text-muted">Sin proveedores asociados</span>
                @endforelse
            </dd>

            <dt class="col-sm-3 text-muted">Estado</dt>
            <dd class="col-sm-9">{{ $product->status->status_name ?? '—' }}</dd>
        </dl>
    </div>
@endsection
