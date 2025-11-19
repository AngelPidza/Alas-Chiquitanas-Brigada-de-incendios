@extends('adminlte::page')

@section('title', 'Mi Perfil')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Mi Perfil</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Mi Perfil</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>¡Error!</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        {{ session('success') }}
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-user mr-1"></i>
                            Información Personal
                        </h3>
                    </div>
                    <form action="{{ route('perfil.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" name="nombre"
                                    class="form-control @error('nombre') is-invalid @enderror"
                                    value="{{ old('nombre', $usuario->nombre) }}" required>
                                @error('nombre')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Apellido</label>
                                <input type="text" name="apellido"
                                    class="form-control @error('apellido') is-invalid @enderror"
                                    value="{{ old('apellido', $usuario->apellido) }}" required>
                                @error('apellido')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Cédula de Identidad</label>
                                <input type="text" class="form-control" value="{{ $usuario->ci }}" disabled>
                                <small class="form-text text-muted">No se puede cambiar</small>
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $usuario->email) }}" required>
                                @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Teléfono</label>
                                <input type="text" name="telefono"
                                    class="form-control @error('telefono') is-invalid @enderror"
                                    value="{{ old('telefono', $usuario->telefono) }}">
                                @error('telefono')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Género</label>
                                        <select name="genero_id"
                                            class="form-control @error('genero_id') is-invalid @enderror">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($generos as $genero)
                                                <option value="{{ $genero->id }}"
                                                    {{ old('genero_id', $usuario->genero_id) == $genero->id ? 'selected' : '' }}>
                                                    {{ $genero->descripcion }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('genero_id')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tipo de Sangre</label>
                                        <select name="tipo_sangre_id"
                                            class="form-control @error('tipo_sangre_id') is-invalid @enderror">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($tiposSangre as $tipo)
                                                <option value="{{ $tipo->id }}"
                                                    {{ old('tipo_sangre_id', $usuario->tipo_sangre_id) == $tipo->id ? 'selected' : '' }}>
                                                    {{ $tipo->codigo }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('tipo_sangre_id')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Fecha de Nacimiento</label>
                                        <input type="date" class="form-control"
                                            value="{{ $usuario->fecha_nacimiento?->format('Y-m-d') }}" disabled>
                                        <small class="form-text text-muted">No se puede cambiar</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nivel de Entrenamiento</label>
                                        <input type="text" class="form-control"
                                            value="{{ $usuario->niveles_entrenamiento?->nivel ?? 'N/A' }}" disabled>
                                        <small class="form-text text-muted">Asignado por administrador</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Rol</label>
                                        <input type="text" class="form-control"
                                            value="{{ $usuario->role?->nombre ?? 'N/A' }}" disabled>
                                        <small class="form-text text-muted">Asignado por administrador</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Estado</label>
                                        <input type="text" class="form-control"
                                            value="{{ $usuario->estados_sistema?->nombre ?? 'N/A' }}" disabled>
                                        <small class="form-text text-muted">Asignado por administrador</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i>
                                Guardar Cambios
                            </button>
                            <a href="{{ route('home') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left mr-1"></i>
                                Volver
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-info">
                        <h3 class="card-title">
                            <i class="fas fa-lock mr-1"></i>
                            Seguridad
                        </h3>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('cambiar-password') }}" class="btn btn-warning btn-block">
                            <i class="fas fa-key mr-1"></i>
                            Cambiar Contraseña
                        </a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-info-circle mr-1"></i>
                            Información del Sistema
                        </h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <tr>
                                <td><strong>Creado:</strong></td>
                                <td>{{ $usuario->creado?->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Actualizado:</strong></td>
                                <td>{{ $usuario->actualizado?->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
