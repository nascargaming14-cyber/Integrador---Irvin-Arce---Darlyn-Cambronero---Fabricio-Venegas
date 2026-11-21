@extends('layouts.app')

@section('title', 'Reservas por proyecto')

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Reservas de material por proyecto</span>
        <a href="{{ route('reservations.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> Nueva reserva
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Producto</th>
                    <th>Proyecto</th>
                    <th class="text-end">Cantidad</th>
                    <th>Estado</th>
                    <th>Usuario</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations as $r)
                    @php
                        $badge = ['activa' => 'warning', 'despachada' => 'success', 'cancelada' => 'secondary'][$r->status] ?? 'light';
                    @endphp
                    <tr>
                        <td>{{ $r->id }}</td>
                        <td>{{ $r->created_at?->format('d/m/Y H:i') }}</td>
                        <td>{{ $r->product->product_name ?? '—' }}</td>
                        <td>{{ $r->project_name }}</td>
                        <td class="text-end">{{ number_format($r->quantity, 2) }}</td>
                        <td><span class="badge text-bg-{{ $badge }}">{{ ucfirst($r->status) }}</span></td>
                        <td>{{ $r->user->user_name ?? '—' }}</td>
                        <td class="text-end">
                            @if($r->status === 'activa')
                                <form method="POST" action="{{ route('reservations.despachar', $r) }}" class="d-inline"
                                      onsubmit="return confirm('¿Registrar la salida de esta reserva?')">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-primary">Registrar salida</button>
                                </form>
                                <form method="POST" action="{{ route('reservations.cancelar', $r) }}" class="d-inline"
                                      onsubmit="return confirm('¿Cancelar esta reserva?')">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-secondary">Cancelar</button>
                                </form>
                            @elseif($r->status === 'despachada')
                                <a href="{{ route('stock-returns.create', ['reservation' => $r->id]) }}"
                                   class="btn btn-sm btn-outline-primary">Devolver</a>
                            @else
                                <span class="text-muted small">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">Todavía no hay reservas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">{{ $reservations->links() }}</div>
</div>
@endsection
