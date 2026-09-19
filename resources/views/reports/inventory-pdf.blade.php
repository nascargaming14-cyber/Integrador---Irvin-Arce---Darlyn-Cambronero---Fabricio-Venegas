<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        th { background-color: #f0f0f0; }
        .low-stock { color: #b00020; font-weight: bold; }
    </style>
</head>
<body>
    <h2>Reporte de Inventario</h2>
    <p>Total de productos: {{ $productos->count() }} | Productos con bajo stock: {{ $bajoStock->count() }}</p>

    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Producto</th>
                <th>Stock</th>
                <th>Stock mínimo</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $p)
            <tr class="{{ $p->stock < $p->minimum_stock ? 'low-stock' : '' }}">
                <td>{{ $p->barcode }}</td>
                <td>{{ $p->product_name }}</td>
                <td>{{ $p->stock }} {{ $p->unitMeasurement->unit_name ?? '' }}</td>
                <td>{{ $p->minimum_stock }}</td>
                <td>{{ $p->stock < $p->minimum_stock ? 'BAJO STOCK' : 'OK' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>