@extends('layouts.app')

@section('title', 'Devoluciones de material')

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Devoluciones de material</span>
        <a href="{{ route('stock-returns.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> Nueva devolución
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Producto</th>
                    <th>Reserva</th>
                    <th>Proyecto</th>
                    <th class="text-end">Cantidad</th>
                    <th>Usuario</th>
                </tr>
            </thead>
            <tbody>
                @forelse($returns as $d)
                    <tr>
                        <td>{{ $d->id }}</td>
                        <td>{{ $d->created_at?->format('d/m/Y H:i') }}</td>
                        <td>{{ $d->product->product_name ?? '—' }}</td>
                        <td>#{{ $d->reservation_id }}</td>
                        <td>{{ $d->reservation->project_name ?? '—' }}</td>
                        <td class="text-end">+{{ number_format($d->quantity, 2) }}</td>
                        <td>{{ $d->user->user_name ?? '—' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Todavía no hay devoluciones registradas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">{{ $returns->links() }}</div>
</div>
@endsection
