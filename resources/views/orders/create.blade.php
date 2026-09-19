@extends('layouts.app')

@section('title', 'Nueva orden')

@push('styles')
<style>
    #details-table td {
        padding-top: 1rem;
        padding-bottom: 1rem;
        vertical-align: top;
    }
    #details-table .qty-cell {
        max-width: 230px;
    }
    #details-table .qty-input {
        min-width: 64px;
        flex: 0 1 90px;
    }
    #details-table .qty-unit-label {
        font-size: 0.76rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 130px;
    }
    #details-table .qty-stock-hint {
        margin-top: 0.35rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 230px;
    }
    #details-table .price-input {
        min-width: 110px;
    }
</style>
@endpush

@section('content')
    <div class="ac-page-head">
        <div>
            <h1>Nueva orden</h1>
            <p>Crea una orden de venta. Los totales se calculan automáticamente.</p>
        </div>
    </div>

    <form action="{{ route('orders.store') }}" method="POST" id="order-form">
        @csrf

                <div class="ac-card p-4 mb-4">
            <h6 class="text-muted mb-3">Datos de la orden</h6>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="customer_id" class="form-label">Cliente</label>
                    <select name="customer_id" id="customer_id"
                            class="form-select @error('customer_id') is-invalid @enderror" required>
                        <option value="">Seleccione un cliente...</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}"
                                {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                {{ $customer->customer_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('customer_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="order_status" class="form-label">Estado del pedido</label>
                    <select name="order_status" id="order_status"
                            class="form-select @error('order_status') is-invalid @enderror">
                        @foreach (['pendiente', 'en proceso', 'completado', 'cancelado'] as $opt)
                            <option value="{{ $opt }}"
                                {{ old('order_status', 'pendiente') == $opt ? 'selected' : '' }}>
                                {{ ucfirst($opt) }}
                            </option>
                        @endforeach
                    </select>
                    @error('order_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="status_id" class="form-label">Estado del registro</label>
                    <select name="status_id" id="status_id"
                            class="form-select @error('status_id') is-invalid @enderror" required>
                        <option value="">Seleccione...</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}"
                                {{ old('status_id') == $status->id ? 'selected' : '' }}>
                                {{ $status->status_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('status_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

                <div class="ac-card p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="text-muted mb-0">Productos</h6>
                <button type="button" id="add-row" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-plus-lg me-1"></i> Agregar producto
                </button>
            </div>

            @error('details')
                <div class="alert alert-danger py-2">{{ $message }}</div>
            @enderror

            <div class="table-responsive">
                <table class="table align-middle mb-0" id="details-table">
                    <thead>
                        <tr>
                            <th style="min-width: 220px">Producto</th>
                            <th style="min-width: 230px">Cantidad</th>
                            <th style="width: 130px">Precio</th>
                            <th style="width: 110px">IVA %</th>
                            <th style="width: 130px">Subtotal</th>
                            <th style="width: 50px"></th>
                        </tr>
                    </thead>
                    <tbody id="details-body"></tbody>
                </table>
            </div>
        </div>

                <div class="ac-card p-4 mb-4" style="max-width: 420px; margin-left: auto;">
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Monto del pedido</span>
                <span id="summary-amount" class="fw-semibold">₡0.00</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">IVA total</span>
                <span id="summary-iva" class="fw-semibold">₡0.00</span>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-2">
                <label for="discount" class="text-muted mb-0">Descuento</label>
                <input type="number" step="0.01" min="0" name="discount" id="discount"
                       class="form-control form-control-sm @error('discount') is-invalid @enderror"
                       style="width: 120px" value="{{ old('discount', 0) }}">
            </div>
            <hr>
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Porcentaje de Pago</span>
                <span id="summary-payment-percent" class="fw-semibold">0%</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Pago</span>
                <span id="summary-payment-paid">₡0.00</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Debe</span>
                <span id="summary-payment-due">₡0.00</span>
            </div>
            <hr>
            <div class="d-flex justify-content-between">
                <span class="fw-bold">Total</span>
                <span id="summary-total" class="fw-bold fs-5">₡0.00</span>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-ac-primary">
                <i class="bi bi-save me-1"></i> Guardar orden
            </button>
            <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>
@endsection

@php
    $acProductsData = $products->map(fn($p) => [
        'id'        => $p->id,
        'name'      => $p->product_name,
        'barcode'   => $p->barcode,
        'price'     => (float) $p->price_sale,
        'unit_name' => $p->unitMeasurement->unit_name ?? 'unidad',
        'stock'     => (float) $p->stock,
        // El controller ya solo manda productos Activo/Disponible con stock > 0,
        // así que aquí siempre van disponibles. Se deja el campo por
        // consistencia con edit.blade.php.
        'available' => true,
    ]);
@endphp

@push('scripts')
<script>
    const acProducts = @json($acProductsData);

    const detailsBody = document.getElementById('details-body');
    const orderForm = document.getElementById('order-form');
    let rowIndex = 0;

    function productOptionsHtml(selectedId = '') {
        let html = '<option value="">Seleccione un producto...</option>';
        acProducts.forEach(p => {
            const sel = String(p.id) === String(selectedId) ? 'selected' : '';
            html += `<option value="${p.id}" data-price="${p.price}" data-unit="${p.unit_name}" data-stock="${p.stock}" data-available="${p.available}" ${sel}>${p.barcode} — ${p.name}</option>`;
        });
        return html;
    }

    function buildRow(data = {}, idx) {
        const tr = document.createElement('tr');
        tr.className = 'detail-row';
        tr.innerHTML = `
            <td>
                <select name="details[${idx}][product_id]" class="form-select form-select-sm product-select" required>
                    ${productOptionsHtml(data.product_id ?? '')}
                </select>
            </td>
            <td class="qty-cell">
                <div class="input-group input-group-sm flex-nowrap">
                    <input type="number" name="details[${idx}][quantity]" class="form-control qty-input"
                           step="0.01" min="0.01" value="${data.quantity ?? 1}" required>
                    <span class="input-group-text qty-unit-label" title="">unidad</span>
                </div>
                <div class="form-text small qty-stock-hint" title=""></div>
            </td>
            <td>
                <input type="number" name="details[${idx}][price]" class="form-control form-control-sm price-input"
                       step="0.01" min="0" value="${data.price ?? ''}" readonly tabindex="-1" required
                       style="background-color:#eef1ea;">
            </td>
            <td>
                <input type="number" name="details[${idx}][iva_percent]" class="form-control form-control-sm iva-input"
                       step="0.01" min="0" value="${data.iva_percent ?? 13}">
            </td>
            <td class="subtotal-cell fw-semibold">₡0.00</td>
            <td class="text-end">
                <button type="button" class="btn btn-sm btn-outline-danger remove-row" title="Quitar">
                    <i class="bi bi-x-lg"></i>
                </button>
            </td>
        `;
        return tr;
    }

    function applyProductInfo(row) {
        const productSelect = row.querySelector('.product-select');
        const priceInput    = row.querySelector('.price-input');
        const qtyInput      = row.querySelector('.qty-input');
        const unitLabel     = row.querySelector('.qty-unit-label');
        const stockHint     = row.querySelector('.qty-stock-hint');

        const opt = productSelect.options[productSelect.selectedIndex];

        if (!opt || !opt.value) {
            priceInput.value = '';
            unitLabel.textContent = 'unidad';
            unitLabel.title = '';
            qtyInput.removeAttribute('max');
            stockHint.textContent = '';
            stockHint.title = '';
            return;
        }

        const price = opt.dataset.price ?? '';
        const unit  = opt.dataset.unit || 'unidad';
        const stock = opt.dataset.stock ?? '';

        priceInput.value = price;
        unitLabel.textContent = unit;
        unitLabel.title = unit;

        if (stock !== '') {
            qtyInput.max = stock;
            const hint = `Disponible: ${parseFloat(stock)} ${unit}`;
            stockHint.textContent = hint;
            stockHint.title = hint;
        } else {
            qtyInput.removeAttribute('max');
            stockHint.textContent = '';
            stockHint.title = '';
        }

        validateQty(qtyInput);
    }

    function validateQty(qtyInput) {
        const max = qtyInput.getAttribute('max');
        if (max && parseFloat(qtyInput.value) > parseFloat(max)) {
            qtyInput.classList.add('is-invalid');
        } else {
            qtyInput.classList.remove('is-invalid');
        }
    }

    function addRow(data = {}) {
        const idx = rowIndex++;
        const row = buildRow(data, idx);
        detailsBody.appendChild(row);

        const productSelect = row.querySelector('.product-select');
        const qtyInput       = row.querySelector('.qty-input');

        productSelect.addEventListener('change', function () {
            applyProductInfo(row);
            recalcTotals();
        });

        qtyInput.addEventListener('input', function () {
            validateQty(qtyInput);
            recalcTotals();
        });

        row.querySelector('.iva-input').addEventListener('input', recalcTotals);

        row.querySelector('.remove-row').addEventListener('click', function () {
            if (detailsBody.querySelectorAll('.detail-row').length > 1) {
                row.remove();
                recalcTotals();
            }
        });

        if (productSelect.value) {
            applyProductInfo(row);
        }

        recalcTotals();
    }

    // Misma regla que el accessor payment_percent del modelo HeaderOrder
    function paymentPercentFor(status) {
        const s = (status || '').toLowerCase();
        if (s === 'completado' || s === 'cancelado') return 100;
        if (s === 'en proceso') return 50;
        return 0;
    }

    function recalcTotals() {
        let amount = 0, ivaTotal = 0;

        document.querySelectorAll('.detail-row').forEach(row => {
            const qty    = parseFloat(row.querySelector('.qty-input').value)   || 0;
            const price  = parseFloat(row.querySelector('.price-input').value) || 0;
            const ivaPct = parseFloat(row.querySelector('.iva-input').value)   || 0;
            const subtotal = qty * price;
            row.querySelector('.subtotal-cell').textContent = '₡' + subtotal.toFixed(2);
            amount   += subtotal;
            ivaTotal += subtotal * (ivaPct / 100);
        });

        const discount = parseFloat(document.getElementById('discount').value) || 0;
        const total = Math.max(amount + ivaTotal - discount, 0);

        document.getElementById('summary-amount').textContent = '₡' + amount.toFixed(2);
        document.getElementById('summary-iva').textContent    = '₡' + ivaTotal.toFixed(2);
        document.getElementById('summary-total').textContent  = '₡' + total.toFixed(2);

        const status  = document.getElementById('order_status').value;
        const percent = paymentPercentFor(status);
        const paid    = Math.round((total * percent / 100) * 100) / 100;
        const due     = Math.round((total - paid) * 100) / 100;

        document.getElementById('summary-payment-percent').textContent = percent + '%';
        document.getElementById('summary-payment-paid').textContent    = '₡' + paid.toFixed(2);
        document.getElementById('summary-payment-due').textContent     = '₡' + due.toFixed(2);
    }

    document.getElementById('add-row').addEventListener('click', () => addRow());
    document.getElementById('discount').addEventListener('input', recalcTotals);
    document.getElementById('order_status').addEventListener('change', recalcTotals);

    orderForm.addEventListener('submit', function (e) {
        const invalidQty = document.querySelector('.qty-input.is-invalid');
        if (invalidQty) {
            e.preventDefault();
            alert('Hay una cantidad que supera el stock disponible. Corrígela antes de guardar la orden.');
        }
    });

    addRow();
</script>
@endpush
