@extends('layouts.app')

@section('title', 'Nueva reserva')

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
    <div class="card-header">Reservar material para un proyecto</div>
    <div class="card-body">
        <form method="POST" action="{{ route('reservations.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Producto</label>
                <select name="product_id" class="form-select" required>
                    <option value="">Seleccione un producto</option>
                    @foreach($products as $p)
                        <option value="{{ $p->id }}" @selected(old('product_id') == $p->id)>
                            {{ $p->product_name }} (disponible {{ number_format($p->stock - $p->reserved_stock, 2) }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                <div class="col-md-8 mb-3">
                    <label class="form-label">Proyecto</label>
                    <input type="text" name="project_name" class="form-control" maxlength="150"
                           value="{{ old('project_name') }}" required>
                </div>
                <div class="col-md-4 mb-3">
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
                <button type="submit" class="btn btn-primary">Crear reserva</button>
                <a href="{{ route('reservations.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
