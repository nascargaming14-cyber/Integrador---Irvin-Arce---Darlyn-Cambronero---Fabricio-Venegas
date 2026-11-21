@extends('layouts.app')

@section('title', 'Nueva devolución')

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
    <div class="card-header">Devolver material sobrante de un proyecto</div>
    <div class="card-body">
        @if($reservations->isEmpty())
            <p class="text-muted mb-0">No hay reservas despachadas con unidades pendientes de devolver.</p>
        @else
            <form method="POST" action="{{ route('stock-returns.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Reserva despachada</label>
                    <select name="reservation_id" class="form-select" required>
                        <option value="">Seleccione una reserva</option>
                        @foreach($reservations as $r)
                            @php $pendiente = (float) $r->quantity - (float) ($r->returned_qty ?? 0); @endphp
                            <option value="{{ $r->id }}" @selected(old('reservation_id', $selected) == $r->id)>
                                #{{ $r->id }} — {{ $r->product->product_name ?? '—' }} — {{ $r->project_name }}
                                (despachado {{ number_format($r->quantity, 2) }}, se pueden devolver {{ number_format($pendiente, 2) }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Cantidad a devolver</label>
                    <input type="number" name="quantity" class="form-control" step="0.01" min="0.01"
                           value="{{ old('quantity') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Notas</label>
                    <textarea name="notes" class="form-control" rows="2" maxlength="500">{{ old('notes') }}</textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Registrar devolución</button>
                    <a href="{{ route('stock-returns.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                </div>
            </form>
        @endif
    </div>
</div>
@endsection
