@extends('layouts.app')

@section('title', 'Usuarios')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Usuarios</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Usuarios</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <i class="icon fas fa-check"></i> {{ session('success') }}
            </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-user-friends mr-1"></i>
                            Listado de Usuarios
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('usuarios.create') }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus"></i> Nuevo Usuario
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover m-0">
                                <thead>
                                    <tr>
                                        <th>Nombre Completo</th>
                                        <th>CI</th>
                                        <th>Email</th>
                                        <th>Rol</th>
                                        <th>Nivel Entrenamiento</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($usuarios as $usuario)
                                        <tr>
                                            <td>
                                                <strong>{{ $usuario->nombre }} {{ $usuario->apellido }}</strong>
                                                @if ($usuario->genero)
                                                    <br><small class="text-muted">
                                                        <i
                                                            class="fas fa-{{ $usuario->genero->codigo == 'M' ? 'mars' : ($usuario->genero->codigo == 'F' ? 'venus' : 'genderless') }}"></i>
                                                        {{ $usuario->genero->descripcion }}
                                                    </small>
                                                @endif
                                            </td>
                                            <td>{{ $usuario->ci }}</td>
                                            <td>
                                                {{ $usuario->email }}
                                                @if ($usuario->telefono)
                                                    <br><small class="text-muted"><i class="fas fa-phone"></i>
                                                        {{ $usuario->telefono }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($usuario->role)
                                                    <span class="badge badge-info">{{ $usuario->role->nombre }}</span>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($usuario->niveles_entrenamiento)
                                                    <span
                                                        class="badge badge-secondary">{{ $usuario->niveles_entrenamiento->nivel }}</span>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($usuario->estados_sistema)
                                                    <span class="badge"
                                                        style="background-color: {{ $usuario->estados_sistema->color ?? '#6c757d' }}; color: white;">
                                                        {{ $usuario->estados_sistema->nombre }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('usuarios.show', $usuario->id) }}"
                                                    class="btn btn-sm btn-info" title="Ver">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('usuarios.edit', $usuario->id) }}"
                                                    class="btn btn-sm btn-primary" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST"
                                                    style="display: inline-block;"
                                                    onsubmit="return confirm('¿Está seguro de eliminar este usuario?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-3">
                                                No hay usuarios registrados
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($usuarios->hasPages())
            <div class="row mt-3">
                <div class="col-md-12">
                    {{ $usuarios->links() }}
                </div>
            </div>
        @endif
    </div>
@stop
