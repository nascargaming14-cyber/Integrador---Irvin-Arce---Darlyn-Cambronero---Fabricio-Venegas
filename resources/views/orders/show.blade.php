@extends('layouts.app')

@section('title', 'Detalle de orden #' . $order->id)

@php
    // Mapeo temporal nombre completo -> abreviatura para mostrar en pantalla.
    // TODO: mover esto a una columna "symbol" en unit_measurements y quitar este helper.
    if (! function_exists('acAbbreviateUnit')) {
        function acAbbreviateUnit($name) {
            $map = [
                'metro cuadrado'  => 'm²',
                'metro cúbico'    => 'm³',
                'metro lineal'    => 'm',
                'metro'           => 'm',
                'kilogramo'       => 'kg',
                'gramo'           => 'g',
                'miligramo'       => 'mg',
                'litro'           => 'l',
                'mililitro'       => 'ml',
                'unidad'          => 'und',
                'unidades'        => 'und',
            ];
            $key = mb_strtolower(trim($name ?? ''));
            return $map[$key] ?? $name;
        }
    }
@endphp

@section('content')
    <div class="ac-page-head">
        <div>
            <h1>Orden #{{ $order->id }}</h1>
            <p>Detalle completo de la orden de venta.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('orders.invoice', $order->id) }}" class="btn btn-ac-primary">
                <i class="bi bi-file-earmark-pdf me-1"></i> Descargar PDF
            </a>
            <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-outline-primary">
                <i class="bi bi-pencil me-1"></i> Editar
            </a>
            <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Volver
            </a>
        </div>
    </div>

    {{-- ── Cabecera ── --}}
    <div class="ac-card p-4 mb-4">
        <h6 class="text-muted mb-3">Información de la orden</h6>
        <dl class="row mb-0">
            <dt class="col-sm-3 text-muted">ID</dt>
            <dd class="col-sm-9">{{ $order->id }}</dd>

            <dt class="col-sm-3 text-muted">Cliente</dt>
            <dd class="col-sm-9">
                <a href="{{ route('customers.show', $order->customer_id) }}" class="text-decoration-none fw-semibold">
                    {{ $order->customer->customer_name ?? '—' }}
                </a>
            </dd>

            <dt class="col-sm-3 text-muted">Fecha</dt>
            <dd class="col-sm-9">{{ $order->order_date?->format('d/m/Y H:i') ?? '—' }}</dd>

            <dt class="col-sm-3 text-muted">Estado del pedido</dt>
            <dd class="col-sm-9">
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
            </dd>

            <dt class="col-sm-3 text-muted">Estado del registro</dt>
            <dd class="col-sm-9">
                @php $sn = strtolower($order->status->status_name ?? ''); @endphp
                <span class="badge {{ str_contains($sn, 'inactiv') ? 'bg-secondary-subtle text-secondary' : 'bg-success-subtle text-success' }}">
                    {{ $order->status->status_name ?? 'Sin estado' }}
                </span>
            </dd>
        </dl>
    </div>

    {{-- ── Líneas de la orden ── --}}
    <div class="ac-card mb-4">
        <div class="p-3 border-bottom fw-semibold">
            Productos ({{ $order->orderDetails->count() }})
        </div>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Producto</th>
                        <th class="text-end">Cantidad</th>
                        <th class="text-end">Precio</th>
                        <th class="text-end">IVA</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($order->orderDetails as $detail)
                        <tr>
                            <td class="ac-mono text-muted">{{ $detail->barcode ?? '—' }}</td>
                            <td>{{ $detail->product_name ?? $detail->product->product_name ?? '—' }}</td>
                            <td class="text-end">
                                {{ number_format($detail->quantity, 2) }}
                                <span class="text-muted">{{ acAbbreviateUnit($detail->unit_name ?? optional(optional($detail->product)->unitMeasurement)->unit_name ?? '') }}</span>
                            </td>
                            <td class="text-end">₡{{ number_format($detail->price, 2) }}</td>
                            <td class="text-end">₡{{ number_format($detail->iva, 2) }}</td>
                            <td class="text-end fw-semibold">₡{{ number_format($detail->subtotal, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">
                                Esta orden no tiene líneas de detalle.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ── Resumen de totales y pago ── --}}
    <div class="ac-card p-4" style="max-width: 380px; margin-left: auto;">
        <div class="d-flex justify-content-between mb-2">
            <span class="text-muted">Monto del pedido</span>
            <span class="fw-semibold">₡{{ number_format($order->order_amount, 2) }}</span>
        </div>
        <div class="d-flex justify-content-between mb-2">
            <span class="text-muted">IVA total</span>
            <span class="fw-semibold">₡{{ number_format($order->orderDetails->sum('iva'), 2) }}</span>
        </div>
        <div class="d-flex justify-content-between mb-2">
            <span class="text-muted">Descuento</span>
            <span>₡{{ number_format($order->discount, 2) }}</span>
        </div>
        <hr>
        <div class="d-flex justify-content-between mb-2">
            <span class="text-muted">Porcentaje de Pago</span>
            <span class="fw-semibold">{{ $order->payment_percent }}%</span>
        </div>
        <div class="d-flex justify-content-between mb-2">
            <span class="text-muted">Pago</span>
            <span>₡{{ number_format($order->payment_paid, 2) }}</span>
        </div>
        <div class="d-flex justify-content-between mb-2">
            <span class="text-muted">Debe</span>
            <span>₡{{ number_format($order->payment_due, 2) }}</span>
        </div>
        <hr>
        <div class="d-flex justify-content-between">
            <span class="fw-bold">Total</span>
            <span class="fw-bold fs-5">₡{{ number_format($order->total, 2) }}</span>
        </div>
    </div>
@endsection
