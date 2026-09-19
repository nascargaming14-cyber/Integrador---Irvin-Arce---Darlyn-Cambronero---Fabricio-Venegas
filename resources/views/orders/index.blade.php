@extends('layouts.app')

@section('title', 'Órdenes')

@section('content')
    <div class="ac-page-head">
        <div>
            <h1>Órdenes</h1>
            <p>Historial y gestión de órdenes de venta.</p>
        </div>
        <a href="{{ route('orders.create') }}" class="btn btn-ac-primary">
            <i class="bi bi-plus-lg me-1"></i> Nueva orden
        </a>
    </div>

    <div class="ac-card">
        <div class="p-3 border-bottom">
            <input type="text" id="ac-search" class="form-control" style="max-width: 340px"
                   placeholder="Buscar por cliente, estado o fecha...">
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0" id="ac-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Monto</th>
                        <th>Descuento</th>
                        <th>Total</th>
                        <th>Estado pedido</th>
                        <th>Pago</th>
                        <th>Registro</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td class="text-muted">{{ $order->id }}</td>
                            <td class="fw-semibold">{{ $order->customer->customer_name ?? '—' }}</td>
                            <td>{{ $order->order_date?->format('d/m/Y H:i') ?? '—' }}</td>
                            <td>₡{{ number_format($order->order_amount, 2) }}</td>
                            <td>{{ $order->discount > 0 ? '₡'.number_format($order->discount, 2) : '—' }}</td>
                            <td class="fw-semibold">₡{{ number_format($order->total, 2) }}</td>
                            <td>
                                @php
                                    $os = strtolower($order->order_status ?? '');
                                    $badge = match(true) {
                                        str_contains($os, 'complet') => 'bg-success-subtle text-success',
                                        str_contains($os, 'cancel')  => 'bg-danger-subtle text-danger',
                                        str_contains($os, 'proceso') => 'bg-warning-subtle text-warning',
                                        default                      => 'bg-secondary-subtle text-secondary',
                                    };
                                @endphp
                                <span class="badge {{ $badge }}">{{ $order->order_status ?? '—' }}</span>
                            </td>
                            <td>
                                <div>{{ $order->payment_percent }}%</div>
                                <div class="small text-muted">
                                    Pagó ₡{{ number_format($order->payment_paid, 2) }} · Debe ₡{{ number_format($order->payment_due, 2) }}
                                </div>
                            </td>
                            <td>
                                @php $sn = strtolower($order->status->status_name ?? ''); @endphp
                                <span class="badge {{ str_contains($sn, 'inactiv') ? 'bg-secondary-subtle text-secondary' : 'bg-success-subtle text-success' }}">
                                    {{ $order->status->status_name ?? 'Sin estado' }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('orders.show', $order->id) }}"
                                   class="btn btn-sm btn-outline-secondary" title="Ver">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('orders.edit', $order->id) }}"
                                   class="btn btn-sm btn-outline-primary" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('orders.destroy', $order->id) }}" method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('¿Eliminar la orden #{{ $order->id }}?');">
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
                            <td colspan="10" class="text-center text-muted py-4">
                                No hay órdenes registradas todavía.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($orders->hasPages())
            <div class="p-3 border-top">
                {{ $orders->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
    const acSearch = document.getElementById('ac-search');
    acSearch?.addEventListener('input', function () {
        const term = this.value.toLowerCase();
        document.querySelectorAll('#ac-table tbody tr').forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(term) ? '' : 'none';
        });
    });
</script>
@endpush
