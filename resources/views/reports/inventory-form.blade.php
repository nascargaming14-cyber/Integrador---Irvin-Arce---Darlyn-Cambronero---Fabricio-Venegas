@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Reporte de Inventario</h2>

    <p class="text-muted">
        Se generará un PDF con todos los productos, ordenados por stock, resaltando
        aquellos por debajo de su stock mínimo.
    </p>

    <form action="{{ route('reports.inventory.pdf') }}" method="GET">
        <button type="submit" class="btn btn-primary">
            Generar PDF
        </button>
    </form>
</div>
@endsection