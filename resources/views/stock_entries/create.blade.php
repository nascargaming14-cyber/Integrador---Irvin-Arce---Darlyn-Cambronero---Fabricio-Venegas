@extends('layouts.app')

@section('title', 'Nueva entrada de inventario')

@section('content')
@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card" style="max-width: 720px;">
    <div class="card-header">Registrar entrada de inventario</div>
    <div class="card-body">
        <form method="POST" action="{{ route('stock-entries.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Producto</label>
                <select name="product_id" class="form-select" required>
                    <option value="">Seleccione un producto</option>
                    @foreach($products as $p)
                        <option value="{{ $p->id }}" @selected(old('product_id') == $p->id)>
                            {{ $p->product_name }} (stock {{ number_format($p->stock, 2) }}, reservado {{ number_format($p->reserved_stock, 2) }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Proveedor</label>
                <select name="supplier_id" class="form-select">
                    <option value="">Sin proveedor</option>
                    @foreach($suppliers as $s)
                        <option value="{{ $s->id }}" @selected(old('supplier_id') == $s->id)>{{ $s->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Referencia de compra</label>
                    <input type="text" name="reference" class="form-control" maxlength="100"
                           value="{{ old('reference') }}" placeholder="Factura o compra #">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Cantidad</label>
                    <input type="number" name="quantity" class="form-control" step="0.01" min="0.01"
                           value="{{ old('quantity') }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Notas</label>
                <textarea name="notes" class="form-control" rows="2" maxlength="500">{{ old('notes') }}</textarea>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Registrar entrada</button>
                <a href="{{ route('stock-entries.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
