@extends('layouts.app')

@section('title', 'Editar subcategoría')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
@endpush

@section('content')
    <div class="ac-page-head">
        <div>
            <h1>Editar subcategoría</h1>
            <p>Actualiza la información de <strong>{{ $subCategory->subcategory_name }}</strong>.</p>
        </div>
        <a href="{{ route('subcategories.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Volver
        </a>
    </div>

    <div class="ac-card p-4" style="max-width: 640px">
        <form action="{{ route('subcategories.update', $subCategory->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="subcategory_name" class="form-label">Nombre de la subcategoría</label>
                <input type="text" name="subcategory_name" id="subcategory_name"
                       class="form-control @error('subcategory_name') is-invalid @enderror"
                       value="{{ old('subcategory_name', $subCategory->subcategory_name) }}"
                       maxlength="100" required autofocus>
                @error('subcategory_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">Categoría</label>
                <select name="category_id" id="category_id"
                        class="form-select @error('category_id') is-invalid @enderror" required>
                    <option value="">Seleccione una categoría...</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', $subCategory->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="unit_ids" class="form-label d-block">Unidades de medida permitidas</label>
                @php
                    $selectedUnitIds = old('unit_ids', $subCategory->allowedUnits->pluck('id')->toArray());
                @endphp
                <select name="unit_ids[]" id="unit_ids" multiple
                        class="form-select @error('unit_ids') is-invalid @enderror">
                    @forelse ($units as $unit)
                        <option value="{{ $unit->id }}"
                            {{ in_array($unit->id, $selectedUnitIds) ? 'selected' : '' }}>
                            {{ $unit->unit_name }}
                        </option>
                    @empty
                    @endforelse
                </select>
                @if($units->isEmpty())
                    <p class="text-muted small mb-0 mt-1">
                        No hay unidades de medida registradas.
                        <a href="{{ route('units.create') }}">Crea una aquí</a>.
                    </p>
                @endif
                <div class="form-text">
                    Al elegir esta subcategoría en un producto, la unidad de medida se llenará sola si solo hay una permitida.
                </div>
                @error('unit_ids')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="status_id" class="form-label">Estado</label>
                <select name="status_id" id="status_id"
                        class="form-select @error('status_id') is-invalid @enderror" required>
                    <option value="">Seleccione un estado...</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status->id }}"
                            {{ old('status_id', $subCategory->status_id) == $status->id ? 'selected' : '' }}>
                            {{ $status->status_name }}
                        </option>
                    @endforeach
                </select>
                @error('status_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-ac-primary">
                    <i class="bi bi-arrow-repeat me-1"></i> Actualizar
                </button>
                <a href="{{ route('subcategories.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script>
    new Choices('#unit_ids', {
        removeItemButton: true,
        placeholder: true,
        placeholderValue: 'Selecciona una o más unidades...',
        searchEnabled: true,
        shouldSort: false,
    });
</script>
@endpush
