<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        th { background-color: #f0f0f0; }
        .total { font-weight: bold; text-align: right; margin-top: 10px; }
    </style>
</head>
<body>
    <h2>Reporte de Ventas</h2>
    <p>Período: {{ $fechaInicio ?? 'N/A' }} - {{ $fechaFin ?? 'N/A' }}</p>

    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>IVA</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($detalles as $d)
            <tr>
                <td>{{ optional($d->headerOrder->order_date)->format('d/m/Y') }}</td>
                <td>{{ $d->headerOrder->customer->customer_name ?? 'N/A' }}</td>
                <td>{{ $d->product->product_name ?? $d->product_name }}</td>
                <td>{{ $d->quantity }}</td>
                <td>₡{{ number_format($d->price, 2) }}</td>
                <td>₡{{ number_format($d->iva, 2) }}</td>
                <td>₡{{ number_format($d->subtotal, 2) }}</td>
            </tr>
            @empty
            <tr><td colspan="7">No se encontraron ventas para estos filtros.</td></tr>
            @endforelse
        </tbody>
    </table>

    <p class="total">Total: ₡{{ number_format($totalVentas, 2) }}</p>
</body>
</html>
