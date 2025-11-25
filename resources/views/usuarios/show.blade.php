@extends('layouts.app')

@section('title', 'Detalles del Usuario')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ $usuario->nombre }} {{ $usuario->apellido }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('usuarios.index') }}">Usuarios</a></li>
                    <li class="breadcrumb-item active">{{ $usuario->nombre }} {{ $usuario->apellido }}</li>
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
            <!-- Información Principal -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-info-circle mr-1"></i>
                            Información Personal
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-4">Nombre Completo:</dt>
                            <dd class="col-sm-8">{{ $usuario->nombre }} {{ $usuario->apellido }}</dd>

                            <dt class="col-sm-4">CI:</dt>
                            <dd class="col-sm-8">{{ $usuario->ci }}</dd>

                            <dt class="col-sm-4">Fecha de Nacimiento:</dt>
                            <dd class="col-sm-8">
                                {{ $usuario->fecha_nacimiento ? $usuario->fecha_nacimiento->format('d/m/Y') : 'N/A' }}
                                @if ($usuario->fecha_nacimiento)
                                    <span class="badge badge-info">{{ $usuario->fecha_nacimiento->age }} años</span>
                                @endif
                            </dd>

                            <dt class="col-sm-4">Género:</dt>
                            <dd class="col-sm-8">
                                @if ($usuario->genero)
                                    <i
                                        class="fas fa-{{ $usuario->genero->codigo == 'M' ? 'mars' : ($usuario->genero->codigo == 'F' ? 'venus' : 'genderless') }}"></i>
                                    {{ $usuario->genero->descripcion }}
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </dd>

                            <dt class="col-sm-4">Email:</dt>
                            <dd class="col-sm-8">
                                <i class="fas fa-envelope"></i> {{ $usuario->email }}
                            </dd>

                            <dt class="col-sm-4">Teléfono:</dt>
                            <dd class="col-sm-8">
                                @if ($usuario->telefono)
                                    <i class="fas fa-phone"></i> {{ $usuario->telefono }}
                                @else
                                    <span class="text-muted">No registrado</span>
                                @endif
                            </dd>

                            <dt class="col-sm-4">Tipo de Sangre:</dt>
                            <dd class="col-sm-8">
                                @if ($usuario->tipos_sangre)
                                    <span class="badge badge-danger">{{ $usuario->tipos_sangre->codigo }}</span>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </dd>
                        </dl>
                    </div>
                </div>

                <!-- Información Profesional -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-briefcase mr-1"></i>
                            Información Profesional
                        </h3>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-4">Rol:</dt>
                            <dd class="col-sm-8">
                                @if ($usuario->role)
                                    <span class="badge badge-info">{{ $usuario->role->nombre }}</span>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </dd>

                            <dt class="col-sm-4">Nivel de Entrenamiento:</dt>
                            <dd class="col-sm-8">
                                @if ($usuario->niveles_entrenamiento)
                                    <span class="badge badge-secondary">{{ $usuario->niveles_entrenamiento->nivel }}</span>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </dd>

                            <dt class="col-sm-4">Entidad Perteneciente:</dt>
                            <dd class="col-sm-8">{{ $usuario->entidad_perteneciente ?? 'No especificada' }}</dd>

                            <dt class="col-sm-4">Estado:</dt>
                            <dd class="col-sm-8">
                                @if ($usuario->estados_sistema)
                                    <span class="badge"
                                        style="background-color: {{ $usuario->estados_sistema->color ?? '#6c757d' }}; color: white;">
                                        {{ $usuario->estados_sistema->nombre }}
                                    </span>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </dd>

                            <dt class="col-sm-4">Fecha de Creación:</dt>
                            <dd class="col-sm-8">{{ $usuario->creado ? $usuario->creado->format('d/m/Y H:i') : 'N/A' }}
                            </dd>

                            <dt class="col-sm-4">Última Actualización:</dt>
                            <dd class="col-sm-8">
                                {{ $usuario->actualizado ? $usuario->actualizado->format('d/m/Y H:i') : 'N/A' }}</dd>
                        </dl>
                    </div>
                </div>

                <!-- Equipos -->
                @if ($usuario->miembros_equipos && $usuario->miembros_equipos->count() > 0)
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-users mr-1"></i>
                                Equipos Asignados
                            </h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Equipo</th>
                                        <th>Fecha de Ingreso</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($usuario->miembros_equipos as $miembro)
                                        <tr>
                                            <td>{{ $miembro->equipo->nombre_equipo ?? 'N/A' }}</td>
                                            <td>{{ $miembro->fecha_ingreso ? \Carbon\Carbon::parse($miembro->fecha_ingreso)->format('d/m/Y') : 'N/A' }}
                                            </td>
                                            <td>
                                                <a href="{{ route('equipos.show', $miembro->equipo->id) }}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i> Ver Equipo
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Panel Lateral -->
            <div class="col-md-4">
                <!-- Acciones Rápidas -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-tasks mr-1"></i>
                            Acciones Rápidas
                        </h3>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-primary btn-block">
                            <i class="fas fa-edit"></i> Editar Usuario
                        </a>
                        <button type="button" class="btn btn-warning btn-block" data-toggle="modal"
                            data-target="#cambiarEstadoModal">
                            <i class="fas fa-exchange-alt"></i> Cambiar Estado
                        </button>
                        <form action="{{ route('usuarios.reset-password', $usuario->id) }}" method="POST"
                            onsubmit="return confirm('¿Está seguro de resetear la contraseña de este usuario?')">
                            @csrf
                            <button type="submit" class="btn btn-info btn-block">
                                <i class="fas fa-key"></i> Resetear Contraseña
                            </button>
                        </form>
                        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary btn-block">
                            <i class="fas fa-arrow-left"></i> Volver al Listado
                        </a>
                        <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST"
                            onsubmit="return confirm('¿Está seguro de eliminar este usuario? Esta acción no se puede deshacer.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-block">
                                <i class="fas fa-trash"></i> Eliminar Usuario
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Info Box Estado -->
                <div class="info-box"
                    style="background-color: {{ $usuario->estados_sistema->color ?? '#6c757d' }}; color: white;">
                    <span class="info-box-icon"><i class="fas fa-info-circle"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Estado Actual</span>
                        <span class="info-box-number">{{ $usuario->estados_sistema->nombre ?? 'N/A' }}</span>
                    </div>
                </div>

                <!-- Info Box Rol -->
                <div class="info-box bg-info">
                    <span class="info-box-icon"><i class="fas fa-user-tag"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Rol del Sistema</span>
                        <span class="info-box-number"
                            style="font-size: 16px;">{{ $usuario->role->nombre ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Cambiar Estado -->
    <div class="modal fade" id="cambiarEstadoModal" tabindex="-1" role="dialog"
        aria-labelledby="cambiarEstadoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('usuarios.estado', $usuario->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-header">
                        <h5 class="modal-title" id="cambiarEstadoModalLabel">
                            <i class="fas fa-exchange-alt"></i> Cambiar Estado de Usuario
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Cambiar el estado de: <strong>{{ $usuario->nombre }} {{ $usuario->apellido }}</strong></p>
                        <p>Estado actual:
                            @if ($usuario->estados_sistema)
                                <span class="badge"
                                    style="background-color: {{ $usuario->estados_sistema->color }}; color: white;">
                                    {{ $usuario->estados_sistema->nombre }}
                                </span>
                            @endif
                        </p>

                        <div class="form-group">
                            <label for="estado_id">Nuevo Estado <span class="text-danger">*</span></label>
                            <select class="form-control" id="estado_id" name="estado_id" required>
                                <option value="">Seleccione un estado...</option>
                                @php
                                    $estados = \App\Models\EstadosSistema::where('tabla', 'usuarios')
                                        ->where('activo', true)
                                        ->orderBy('orden')
                                        ->get();
                                @endphp
                                @foreach ($estados as $estado)
                                    <option value="{{ $estado->id }}"
                                        {{ $usuario->estado_id == $estado->id ? 'selected' : '' }}>
                                        {{ $estado->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Cambiar Estado
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
