@extends('layouts.app')

@section('title', 'Detalle de cliente')

@section('content')
    <div class="ac-page-head">
        <div>
            <h1>{{ $customer->customer_name }}</h1>
            <p>Detalle del cliente e historial de órdenes.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-outline-primary">
                <i class="bi bi-pencil me-1"></i> Editar
            </a>
            <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Volver
            </a>
        </div>
    </div>

    <div class="ac-card p-4 mb-4">
        <dl class="row mb-0">
            <dt class="col-sm-3 text-muted">ID</dt>
            <dd class="col-sm-9">{{ $customer->id }}</dd>

            <dt class="col-sm-3 text-muted">Nombre</dt>
            <dd class="col-sm-9">{{ $customer->customer_name }}</dd>

            <dt class="col-sm-3 text-muted">DNI</dt>
            <dd class="col-sm-9 ac-mono">{{ $customer->dni ?? '—' }}</dd>

            <dt class="col-sm-3 text-muted">Correo</dt>
            <dd class="col-sm-9">{{ $customer->email ?? '—' }}</dd>

            <dt class="col-sm-3 text-muted">Teléfono</dt>
            <dd class="col-sm-9">{{ $customer->telephone ?? '—' }}</dd>

            <dt class="col-sm-3 text-muted">Estado</dt>
            <dd class="col-sm-9">
                @php $statusName = strtolower($customer->status->status_name ?? ''); @endphp
                <span class="badge {{ str_contains($statusName, 'inactiv') ? 'bg-secondary-subtle text-secondary' : 'bg-success-subtle text-success' }}">
                    {{ $customer->status->status_name ?? 'Sin estado' }}
                </span>
            </dd>
        </dl>
    </div>

    <div class="ac-card">
        <div class="p-3 border-bottom fw-semibold">Órdenes del cliente ({{ $customer->headerOrders->count() }})</div>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Estado del pedido</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($customer->headerOrders as $order)
                        <tr>
                            <td class="text-muted">{{ $order->id }}</td>
                            <td>{{ $order->order_date?->format('d/m/Y H:i') ?? '—' }}</td>
                            <td>${{ number_format($order->total, 2) }}</td>
                            <td>{{ $order->order_status ?? '—' }}</td>
                            <td class="text-end">
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-secondary" title="Ver">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-3">Este cliente no tiene órdenes registradas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection