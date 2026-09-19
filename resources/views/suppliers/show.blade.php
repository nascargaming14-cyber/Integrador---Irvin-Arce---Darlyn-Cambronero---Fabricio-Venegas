@extends('layouts.app')

@section('title', 'Detalle de proveedor')

@section('content')
    <div class="ac-page-head">
        <div>
            <h1>{{ $supplier->name }}</h1>
            <p>Detalle del proveedor y productos asociados.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-outline-primary">
                <i class="bi bi-pencil me-1"></i> Editar
            </a>
            <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Volver
            </a>
        </div>
    </div>

    <div class="ac-card p-4 mb-4">
        <dl class="row mb-0">
            <dt class="col-sm-3 text-muted">Nombre</dt>
            <dd class="col-sm-9">{{ $supplier->name }}</dd>

            <dt class="col-sm-3 text-muted">Estado</dt>
            <dd class="col-sm-9">{{ $supplier->status->status_name ?? '—' }}</dd>
        </dl>
    </div>

    <div class="ac-card">
        <div class="p-3 border-bottom fw-semibold">Productos asociados ({{ $supplier->products->count() }})</div>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Producto</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($supplier->products as $product)
                        <tr>
                            <td class="text-muted">{{ $product->id }}</td>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ $product->status->status_name ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center text-muted py-3">Sin productos asociados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection