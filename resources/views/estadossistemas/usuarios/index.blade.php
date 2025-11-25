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
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-users mr-1"></i>
                            Listado de Usuarios
                        </h3>
                        <div class="card-tools">
                            <form action="{{ route('usuarios.index') }}" method="GET" class="form-inline"
                                autocomplete="off">
                                <div class="input-group input-group-sm" style="width: 250px;">
                                </div>
                            </form>
                            @if (request('q'))
                                <a href="{{ route('usuarios.index') }}" class="btn btn-sm btn-tool ml-2"
                                    title="Limpiar búsqueda">
                                    <i class="fas fa-times"></i>
                                </a>
                            @endif
                            <a class="btn btn-sm btn-primary ml-2" href="{{ route('usuarios.create') }}">
                                <i class="fas fa-plus mr-1"></i> Agregar Usuario
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
                                        <th>Teléfono</th>
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
                                            </td>
                                            <td>{{ $usuario->ci }}</td>
                                            <td>{{ $usuario->email }}</td>
                                            <td>{{ $usuario->telefono }}</td>
                                            <td>{{ $usuario->role->nombre ?? '-' }}</td>
                                            <td>{{ $usuario->nivelesEntrenamiento->nivel ?? '-' }}</td>
                                            <td>
                                                @if ($usuario->estadoSistema)
                                                    @switch($usuario->estadoSistema->nombre)
                                                        @case('Activo')
                                                            <span
                                                                class="badge badge-success">{{ $usuario->estadoSistema->nombre }}</span>
                                                        @break

                                                        @case('Inactivo')
                                                            <span
                                                                class="badge badge-secondary">{{ $usuario->estadoSistema->nombre }}</span>
                                                        @break

                                                        @case('Mantenimiento')
                                                            <span
                                                                class="badge badge-warning">{{ $usuario->estadoSistema->nombre }}</span>
                                                        @break

                                                        @default
                                                            <span
                                                                class="badge badge-default">{{ $usuario->estadoSistema->nombre }}</span>
                                                    @endswitch
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('usuarios.show', $usuario) }}"
                                                    class="btn btn-sm btn-primary" title="Ver">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('usuarios.edit', $usuario) }}"
                                                    class="btn btn-sm btn-info" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center text-muted py-3">
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
