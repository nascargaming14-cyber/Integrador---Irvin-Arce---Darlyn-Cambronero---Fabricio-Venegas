@extends('layouts.app')

@section('title', 'Detalle de unidad de medida')

@section('content')
    <div class="ac-page-head">
        <div>
            <h1>{{ $unit->unit_name }}</h1>
            <p>Detalle de la unidad de medida y productos asociados.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('units.edit', $unit->id) }}" class="btn btn-outline-primary">
                <i class="bi bi-pencil me-1"></i> Editar
            </a>
            <a href="{{ route('units.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Volver
            </a>
        </div>
    </div>

    <div class="ac-card p-4 mb-4">
        <dl class="row mb-0">
            <dt class="col-sm-3 text-muted">Nombre</dt>
            <dd class="col-sm-9">{{ $unit->unit_name }}</dd>

            <dt class="col-sm-3 text-muted">Estado</dt>
            <dd class="col-sm-9">{{ $unit->status->status_name ?? '—' }}</dd>
        </dl>
    </div>

    <div class="ac-card">
        <div class="p-3 border-bottom fw-semibold">Productos que usan esta unidad ({{ $unit->products->count() }})</div>
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
                    @forelse ($unit->products as $product)
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
