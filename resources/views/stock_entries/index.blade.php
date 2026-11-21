@extends('layouts.app')

@section('title', 'Entradas de inventario')

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Entradas de inventario</span>
        <a href="{{ route('stock-entries.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> Nueva entrada
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Producto</th>
                    <th>Proveedor</th>
                    <th>Referencia</th>
                    <th class="text-end">Cantidad</th>
                    <th>Usuario</th>
                </tr>
            </thead>
            <tbody>
                @forelse($entries as $e)
                    <tr>
                        <td>{{ $e->id }}</td>
                        <td>{{ $e->created_at?->format('d/m/Y H:i') }}</td>
                        <td>{{ $e->product->product_name ?? '—' }}</td>
                        <td>{{ $e->supplier->name ?? '—' }}</td>
                        <td>{{ $e->reference ?? '—' }}</td>
                        <td class="text-end">+{{ number_format($e->quantity, 2) }}</td>
                        <td>{{ $e->user->user_name ?? '—' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Todavía no hay entradas registradas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">{{ $entries->links() }}</div>
</div>
@endsection
