@extends('layouts.app')

@section('title', 'Editar usuario')

@section('content')
    <div class="ac-page-head">
        <div>
            <h1>Editar usuario</h1>
            <p>Actualiza la información de <strong>{{ $user->user_name }}</strong>.</p>
        </div>
        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Volver
        </a>
    </div>

    <div class="ac-card p-4" style="max-width: 600px">
        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="user_name" class="form-control @error('user_name') is-invalid @enderror"
                       value="{{ old('user_name', $user->user_name) }}" required autofocus>
                @error('user_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Correo electrónico</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', $user->email) }}" required>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Teléfono</label>
                <input type="text" name="telephone" class="form-control @error('telephone') is-invalid @enderror"
                       value="{{ old('telephone', $user->telephone) }}">
                @error('telephone') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nueva contraseña (opcional)</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                           placeholder="Dejar en blanco para no cambiar">
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
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                {{ $role->role_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('role_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Estado</label>
                    <select name="status_id" class="form-select @error('status_id') is-invalid @enderror" required>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}" {{ old('status_id', $user->status_id) == $status->id ? 'selected' : '' }}>
                                {{ $status->status_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('status_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-ac-primary">
                    <i class="bi bi-arrow-repeat me-1"></i> Actualizar
                </button>
                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection