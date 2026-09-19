@extends('layouts.app')

@section('title', 'Panel')

@section('content')

    {{-- Banner de alerta --}}
    @if($alertasActivas > 0)
    <div class="alert alert-danger d-flex align-items-center justify-content-between alert-dismissible fade show mb-4" role="alert">
        <div>
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <strong>{{ $alertasActivas }}</strong>
            {{ $alertasActivas == 1 ? 'producto está' : 'productos están' }} por debajo del stock mínimo.
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <h1 class="fw-bold mb-1" style="font-size:1.6rem;">Panel</h1>
    <p class="text-muted mb-4">Vista general del inventario</p>

    {{-- Tarjetas resumen --}}
    <div class="row g-3 mb-4">

        <div class="col-6 col-lg-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <span class="text-uppercase text-muted small fw-bold" style="font-size:0.7rem;">Total Productos</span>
                        <span class="bg-light rounded-2 p-2 text-secondary"><i class="bi bi-box-seam"></i></span>
                    </div>
                    <p class="fs-2 fw-bold mb-0 mt-2">{{ $totalProductos }}</p>
                    <p class="text-muted small mb-0">En bodega activa</p>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <span class="text-uppercase text-muted small fw-bold" style="font-size:0.7rem;">Alertas Activas</span>
                        <span class="bg-warning-subtle rounded-2 p-2 text-warning"><i class="bi bi-exclamation-triangle"></i></span>
                    </div>
                    <p class="fs-2 fw-bold mb-0 mt-2 text-danger">{{ $alertasActivas }}</p>
                    <p class="text-muted small mb-0">Productos bajo stock mínimo</p>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <span class="text-uppercase text-muted small fw-bold" style="font-size:0.7rem;">Ventas del Mes</span>
                        <span class="bg-light rounded-2 p-2 text-secondary"><i class="bi bi-receipt"></i></span>
                    </div>
                    <p class="fs-2 fw-bold mb-0 mt-2">{{ $ventasDelMes }}</p>
                    <p class="text-muted small mb-0">Órdenes registradas</p>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <span class="text-uppercase text-muted small fw-bold" style="font-size:0.7rem;">Proveedores</span>
                        <span class="rounded-2 p-2" style="background:#eef7e2;color:#4c7a28;"><i class="bi bi-truck"></i></span>
                    </div>
                    <p class="fs-2 fw-bold mb-0 mt-2">{{ $proveedoresActivos }}</p>
                    <p class="text-muted small mb-0">Activos registrados</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Movimientos recientes + Alertas de stock --}}
    <div class="row g-3">

        {{-- Tabla de movimientos --}}
        <div class="col-12 col-lg-8">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Movimientos Recientes</span>
                    @if(Route::has('movements.index'))
                        <a href="{{ route('movements.index') }}" class="small text-decoration-none" style="color:#4c7a28;">Ver todos</a>
                    @endif
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-3">Fecha</th>
                                    <th>Producto</th>
                                    <th>Tipo</th>
                                    <th>Cant.</th>
                                    <th>Usuario</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($movimientosRecientes as $mov)
                                <tr>
                                    <td class="ps-3">{{ $mov->created_at->format('d/m/y') }}</td>
                                    <td>{{ $mov->product->product_name ?? '—' }}</td>
                                    <td>
                                        @if($mov->type === 'entrada')
                                            <span class="badge bg-success-subtle text-success">Entrada</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger">Salida</span>
                                        @endif
                                    </td>
                                    <td>{{ rtrim(rtrim(number_format($mov->quantity, 2), '0'), '.') }}</td>
                                    <td>{{ $mov->user->user_name ?? '—' }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="5" class="text-center text-muted py-4">Sin movimientos registrados</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Alertas de stock + gráfico --}}
        <div class="col-12 col-lg-4">
            <div class="card h-100" id="alertas">
                <div class="card-header">
                    <i class="bi bi-exclamation-triangle text-warning me-1"></i> Alertas de Stock
                </div>
                <div class="card-body">
                    @forelse($productosStockBajo as $producto)
                    <div class="d-flex align-items-start gap-2 rounded-3 p-2 mb-2 {{ $producto->stock == 0 ? 'bg-danger-subtle' : 'bg-warning-subtle' }}">
                        <span class="rounded-circle mt-1 {{ $producto->stock == 0 ? 'bg-danger' : 'bg-warning' }}" style="width:9px;height:9px;flex-shrink:0;"></span>
                        <div>
                            <p class="mb-0 small fw-semibold">
                                {{ $producto->product_name }} @if($producto->stock == 0) — AGOTADO @endif
                            </p>
                            <p class="mb-0 text-muted" style="font-size:0.75rem;">
                                Stock: {{ rtrim(rtrim(number_format($producto->stock, 2), '0'), '.') }} {{ $producto->unitMeasurement->unit_name ?? '' }}
                                | Min: {{ rtrim(rtrim(number_format($producto->minimum_stock, 2), '0'), '.') }} {{ $producto->unitMeasurement->unit_name ?? '' }}
                            </p>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted small mb-0">No hay alertas de stock 🎉</p>
                    @endforelse

                    <hr>

                    <h2 class="fw-semibold text-muted mb-2" style="font-size:0.8rem;">Ventas - últimas 6 semanas</h2>
                    <canvas id="ventasChart" height="90"></canvas>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script>
    const ctx = document.getElementById('ventasChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json(collect($ventasSemanales)->pluck('label')),
            datasets: [{
                data: @json(collect($ventasSemanales)->pluck('total')),
                backgroundColor: '#86efac',
                borderRadius: 4,
                barThickness: 18,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false } },
                y: { display: false }
            }
        }
    });
</script>
@endpush
