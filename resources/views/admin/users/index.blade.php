@extends('layouts.app')

@section('title', 'Usuarios')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-0" style="color:#1a1f2e">Usuarios</h2>
        <p class="text-muted small mb-0">Administración de usuarios del sistema</p>
    </div>
    <a href="{{ route('users.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Nuevo usuario
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th class="ps-4">#</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th class="text-end pe-4">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td class="ps-4">{{ $user->id }}</td>
                        <td>{{ $user->user_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td><span class="badge bg-secondary">{{ $user->role->role_name ?? '—' }}</span></td>
                        <td>{{ $user->status->status_name ?? '—' }}</td>
                        <td class="text-end pe-4">
                            <a href="{{ route('users.edit', $user->id) }}"
                               class="btn btn-sm btn-outline-secondary me-1" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @if ($user->id !== auth()->id())
                                <form action="{{ route('users.destroy', $user->id) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('¿Eliminar este usuario?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No hay usuarios registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $users->links('pagination::bootstrap-5') }}
</div>

@endsection