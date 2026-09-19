@extends('layouts.app')

@section('title', 'Editar categoría')

@section('content')
    <div class="ac-page-head">
        <div>
            <h1>Editar categoría</h1>
            <p>Actualiza la información de <strong>{{ $category->category_name }}</strong>.</p>
        </div>
        <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Volver
        </a>
    </div>

    <div class="ac-card p-4" style="max-width: 560px">
        <form action="{{ route('categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="category_name" class="form-label">Nombre de la categoría</label>
                <input type="text" name="category_name" id="category_name"
                       class="form-control @error('category_name') is-invalid @enderror"
                       value="{{ old('category_name', $category->category_name) }}"
                       maxlength="100" required autofocus>
                @error('category_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="status_id" class="form-label">Estado</label>
                <select name="status_id" id="status_id"
                        class="form-select @error('status_id') is-invalid @enderror" required>
                    <option value="">Seleccione un estado...</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status->id }}"
                            {{ old('status_id', $category->status_id) == $status->id ? 'selected' : '' }}>
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
                <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection