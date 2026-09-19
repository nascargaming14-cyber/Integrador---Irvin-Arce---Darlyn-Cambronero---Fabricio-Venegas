<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</title>
    <style>
        @page {
            /* Dejamos margen inferior amplio para que el pie de página fijo
               (ver .invoice-footer más abajo) tenga espacio sin pisar el contenido */
            margin: 28px 34px 130px 34px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #2b2f38;
            margin: 0;
            padding: 0;
        }

        .accent-bar {
            height: 6px;
            background: #3f5c22;
            width: 100%;
            margin-bottom: 22px;
        }

        /* ── Encabezado ── */
        table.header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }

        table.header-table td {
            vertical-align: top;
        }

        .logo {
            max-width: 190px;
            max-height: 80px;
            margin-bottom: 8px;
        }

        .company-meta {
            font-size: 9.5px;
            color: #6b7280;
            line-height: 1.5;
        }

        .invoice-box {
            text-align: right;
        }

        .invoice-title {
            font-size: 22px;
            font-weight: bold;
            color: #3f5c22;
            margin: 0 0 6px 0;
            letter-spacing: 1px;
        }

        .invoice-number {
            font-size: 12px;
            font-weight: bold;
            color: #2b2f38;
        }

        .invoice-meta {
            font-size: 9.5px;
            color: #6b7280;
            margin-top: 6px;
            line-height: 1.6;
        }

        .status-pill {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 6px;
            background: #eef7d9;
            color: #4a6b1c;
        }

        /* ── Bloque cliente ── */
        .bill-to {
            background: #f6f7f9;
            border-left: 3px solid #3f5c22;
            padding: 12px 16px;
            margin-bottom: 22px;
        }

        .bill-to-label {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #6b7280;
            margin: 0 0 4px 0;
        }

        .bill-to-name {
            font-size: 13px;
            font-weight: bold;
            color: #2b2f38;
            margin: 0;
        }

        /* ── Tabla de productos ── */
        table.items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }

        table.items-table thead th {
            background: #3f5c22;
            color: #ffffff;
            font-size: 9.5px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            padding: 9px 10px;
            text-align: left;
        }

        table.items-table thead th.num {
            text-align: right;
        }

        table.items-table tbody td {
            padding: 9px 10px;
            font-size: 10.5px;
            border-bottom: 1px solid #e5e7eb;
        }

        table.items-table tbody tr:nth-child(even) {
            background: #fafbfc;
        }

        table.items-table td.num {
            text-align: right;
        }

        .product-code {
            color: #9ca3af;
            font-size: 9px;
        }

        /* ── Totales ── */
        table.totals-table {
            width: 260px;
            margin-left: auto;
            border-collapse: collapse;
            margin-top: 4px;
        }

        table.totals-table td {
            padding: 5px 10px;
            font-size: 10.5px;
        }

        table.totals-table td.label {
            color: #6b7280;
            text-align: right;
        }

        table.totals-table td.value {
            text-align: right;
            width: 100px;
        }

        table.totals-table tr.total-row td {
            border-top: 3px solid #93c90f;
            font-size: 14px;
            font-weight: bold;
            color: #3f5c22;
            padding-top: 10px;
        }

        /* ── Pie de página FIJO ──
           position: fixed hace que DomPDF repita este bloque en la
           misma posición de CADA página, siempre pegado al borde
           inferior, sin importar cuánto contenido haya arriba. */
        .invoice-footer {
            position: fixed;
            bottom: -110px;
            left: 0;
            right: 0;
            text-align: center;
        }

        .thanks {
            text-align: center;
            font-size: 12px;
            font-weight: bold;
            color: #3f5c22;
            margin: 0 0 10px 0;
        }

        .footer-fineprint {
            padding-top: 14px;
            border-top: 1px solid #e5e7eb;
            font-size: 9px;
            color: #9ca3af;
            text-align: center;
            line-height: 1.6;
        }
    </style>
</head>
<body>

    {{--
        ═══════════════════════════════════════════════
        DATOS DE LA EMPRESA
        ═══════════════════════════════════════════════
    --}}
    @php
        // Mapeo temporal nombre completo -> abreviatura para mostrar en la factura.
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

        $companyName    = 'Servigrama S.A.';
        $companyAddress = 'San Pedro, Sarchí, Alajuela, Costa Rica';
        $companyPhones  = '+(506) 2454-1600 / +(506) 8317-2732';
        $companyEmails  = 'ventas@servigrama.com / cesped@servigrama.com';
        // Ruta del logo dentro de tu proyecto Laravel (ver instrucciones más abajo)
        $logoPath = public_path('Imagenes/servigrama.png');
    @endphp

    {{-- ── Pie de página fijo: se repite igual en todas las páginas ── --}}
    <div class="invoice-footer">
        <p class="thanks">¡Gracias por su compra!</p>
        <div class="footer-fineprint">
            Este documento fue generado electrónicamente y es válido como comprobante de la operación.<br>
            {{ $companyName }} &nbsp;·&nbsp; {{ $companyPhones }} &nbsp;·&nbsp; {{ $companyEmails }}
        </div>
    </div>

    <div class="accent-bar"></div>

    <table class="header-table">
        <tr>
            <td style="width: 55%;">
                @if (file_exists($logoPath))
                    <img src="{{ $logoPath }}" class="logo" alt="{{ $companyName }}">
                @endif
                <div class="company-meta">
                    {{ $companyAddress }}<br>
                    Tel: {{ $companyPhones }}<br>
                    {{ $companyEmails }}
                </div>
            </td>
            <td class="invoice-box" style="width: 45%;">
                <p class="invoice-title">FACTURA</p>
                <div class="invoice-number">N.º {{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</div>
                <div class="invoice-meta">
                    Fecha de emisión: {{ $order->order_date?->format('d/m/Y') ?? now()->format('d/m/Y') }}<br>
                    Hora: {{ $order->order_date?->format('H:i') ?? now()->format('H:i') }}
                </div>
                <div class="status-pill">{{ $order->order_status ?? 'Pendiente' }}</div>
            </td>
        </tr>
    </table>

    <div class="bill-to">
        <p class="bill-to-label">Facturado a</p>
        <p class="bill-to-name">{{ $order->customer->customer_name ?? '—' }}</p>
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 12%;">Código</th>
                <th style="width: 33%;">Producto</th>
                <th class="num" style="width: 17%;">Cant.</th>
                <th class="num" style="width: 13%;">Precio</th>
                <th class="num" style="width: 10%;">IVA</th>
                <th class="num" style="width: 15%;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($order->orderDetails as $detail)
                <tr>
                    <td class="product-code">{{ $detail->barcode ?? '—' }}</td>
                    <td>{{ $detail->product_name ?? $detail->product->product_name ?? '—' }}</td>
                    <td class="num">
                        {{ number_format($detail->quantity, 2) }}
                        {{ acAbbreviateUnit($detail->unit_name ?? optional(optional($detail->product)->unitMeasurement)->unit_name ?? '') }}
                    </td>
                    <td class="num">₡{{ number_format($detail->price, 2) }}</td>
                    <td class="num">₡{{ number_format($detail->iva, 2) }}</td>
                    <td class="num"><strong>₡{{ number_format($detail->subtotal, 2) }}</strong></td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center; color:#9ca3af; padding: 16px;">
                        Esta orden no tiene líneas de detalle.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table class="totals-table">
        <tr>
            <td class="label">Monto del pedido</td>
            <td class="value">₡{{ number_format($order->order_amount, 2) }}</td>
        </tr>
        <tr>
            <td class="label">IVA total</td>
            <td class="value">₡{{ number_format($order->orderDetails->sum('iva'), 2) }}</td>
        </tr>
        <tr>
            <td class="label">Descuento</td>
            <td class="value">-₡{{ number_format($order->discount, 2) }}</td>
        </tr>
        <tr>
            <td class="label" style="padding-top: 10px;">Porcentaje de Pago</td>
            <td class="value" style="padding-top: 10px;">{{ $order->payment_percent }}%</td>
        </tr>
        <tr>
            <td class="label">Pago</td>
            <td class="value">₡{{ number_format($order->payment_paid, 2) }}</td>
        </tr>
        <tr>
            <td class="label">Debe</td>
            <td class="value">₡{{ number_format($order->payment_due, 2) }}</td>
        </tr>
        <tr class="total-row">
            <td class="label">TOTAL</td>
            <td class="value">₡{{ number_format($order->total, 2) }}</td>
        </tr>
    </table>

</body>
</html>
