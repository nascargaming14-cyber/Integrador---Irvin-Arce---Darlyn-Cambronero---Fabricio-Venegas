@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Reporte de Ventas</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('reports.sales.pdf') }}" method="GET" class="row g-3">
        <div class="col-md-3">
            <label for="fecha_inicio" class="form-label">Fecha inicio</label>
            <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control"
                   max="{{ now()->format('Y-m-d') }}"
                   value="{{ old('fecha_inicio') }}">
        </div>

        <div class="col-md-3">
            <label for="fecha_fin" class="form-label">Fecha fin</label>
            <input type="date" name="fecha_fin" id="fecha_fin" class="form-control"
                   max="{{ now()->format('Y-m-d') }}"
                   value="{{ old('fecha_fin') }}">
        </div>

        <div class="col-md-3">
            <label for="customer_id" class="form-label">Cliente</label>
            <select name="customer_id" id="customer_id" class="form-select">
                <option value="">Todos</option>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label for="product_id" class="form-label">Producto</label>
            <select name="product_id" id="product_id" class="form-select">
                <option value="">Todos</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary">
                Generar PDF
            </button>
        </div>
    </form>
</div>
@endsection
