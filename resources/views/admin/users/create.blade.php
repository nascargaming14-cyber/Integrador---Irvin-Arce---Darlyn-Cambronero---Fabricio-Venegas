@extends('layouts.app')

@section('title', 'Nuevo usuario')

@section('content')
    <div class="ac-page-head">
        <div>
            <h1>Nuevo usuario</h1>
            <p>Registra un nuevo usuario del sistema.</p>
        </div>
        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Volver
        </a>
    </div>

    <div class="ac-card p-4" style="max-width: 600px">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="user_name" class="form-control @error('user_name') is-invalid @enderror"
                       value="{{ old('user_name') }}" required autofocus>
                @error('user_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Correo electrónico</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}" required>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Teléfono</label>
                <input type="text" name="telephone" class="form-control @error('telephone') is-invalid @enderror"
                       value="{{ old('telephone') }}">
                @error('telephone') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Confirmar contraseña</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Rol</label>
                    <select name="role_id" class="form-select @error('role_id') is-invalid @enderror" required>
                        <option value="">Seleccione...</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                {{ $role->role_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('role_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Estado</label>
                    <select name="status_id" class="form-select @error('status_id') is-invalid @enderror" required>
                        <option value="">Seleccione...</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}" {{ old('status_id') == $status->id ? 'selected' : '' }}>
                                {{ $status->status_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('status_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-ac-primary">
                    <i class="bi bi-save me-1"></i> Guardar
                </button>
                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection