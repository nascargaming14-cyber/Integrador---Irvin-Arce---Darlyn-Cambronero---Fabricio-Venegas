@extends('layouts.app')

@section('title', 'Clientes')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-0" style="color:#1a1f2e">Clientes</h2>
        <p class="text-muted small mb-0">Listado de todos los clientes registrados</p>
    </div>
    <a href="{{ route('customers.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Nuevo cliente
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
                    <th>Email</th>
                    <th>Estado</th>
                    <th class="text-end pe-4">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($customers as $customer)
                    <tr>
                        <td class="ps-4">{{ $customer->id }}</td>
                        <td>{{ $customer->customer_name }}</td>
                        <td>{{ $customer->email ?? '—' }}</td>
                        <td>{{ $customer->status->status_name ?? '—' }}</td>
                        <td class="text-end pe-4">
                            <a href="{{ route('customers.edit', $customer->id) }}"
                               class="btn btn-sm btn-outline-secondary me-1" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('customers.destroy', $customer->id) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('¿Eliminar este cliente?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">No hay clientes registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $customers->links() }}
</div>

@endsection