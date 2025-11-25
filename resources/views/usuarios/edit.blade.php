@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Editar Usuario</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('usuarios.index') }}">Usuarios</a></li>
                    <li class="breadcrumb-item active">Editar</li>
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
                            <i class="fas fa-user-edit mr-1"></i>
                            Editar Información de {{ $usuario->nombre }} {{ $usuario->apellido }}
                        </h3>
                    </div>
                    <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <h5 class="mb-3"><i class="fas fa-id-card"></i> Información Personal</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nombre">Nombre <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                                            id="nombre" name="nombre" value="{{ old('nombre', $usuario->nombre) }}"
                                            required>
                                        @error('nombre')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="apellido">Apellido <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('apellido') is-invalid @enderror"
                                            id="apellido" name="apellido" value="{{ old('apellido', $usuario->apellido) }}"
                                            required>
                                        @error('apellido')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ci">CI <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('ci') is-invalid @enderror"
                                            id="ci" name="ci" value="{{ old('ci', $usuario->ci) }}" required>
                                        @error('ci')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="fecha_nacimiento">Fecha de Nacimiento <span
                                                class="text-danger">*</span></label>
                                        <input type="date"
                                            class="form-control @error('fecha_nacimiento') is-invalid @enderror"
                                            id="fecha_nacimiento" name="fecha_nacimiento"
                                            value="{{ old('fecha_nacimiento', $usuario->fecha_nacimiento?->format('Y-m-d')) }}"
                                            required>
                                        @error('fecha_nacimiento')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="genero_id">Género <span class="text-danger">*</span></label>
                                        <select class="form-control @error('genero_id') is-invalid @enderror" id="genero_id"
                                            name="genero_id" required>
                                            <option value="">Seleccione...</option>
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
                            </div>

                            <h5 class="mb-3 mt-4"><i class="fas fa-envelope"></i> Información de Contacto</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email', $usuario->email) }}"
                                            required>
                                        @error('email')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="telefono">Teléfono</label>
                                        <input type="text" class="form-control @error('telefono') is-invalid @enderror"
                                            id="telefono" name="telefono"
                                            value="{{ old('telefono', $usuario->telefono) }}">
                                        @error('telefono')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <h5 class="mb-3 mt-4"><i class="fas fa-lock"></i> Cambiar Contraseña</h5>
                            <p class="text-muted"><small>Deje en blanco si no desea cambiar la contraseña</small></p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">Nueva Contraseña</label>
                                        <input type="password"
                                            class="form-control @error('password') is-invalid @enderror" id="password"
                                            name="password">
                                        @error('password')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                        <small class="form-text text-muted">Mínimo 6 caracteres</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password_confirmation">Confirmar Nueva Contraseña</label>
                                        <input type="password" class="form-control" id="password_confirmation"
                                            name="password_confirmation">
                                    </div>
                                </div>
                            </div>

                            <h5 class="mb-3 mt-4"><i class="fas fa-briefcase"></i> Información Profesional</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tipo_sangre_id">Tipo de Sangre</label>
                                        <select class="form-control @error('tipo_sangre_id') is-invalid @enderror"
                                            id="tipo_sangre_id" name="tipo_sangre_id">
                                            <option value="">Seleccione...</option>
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
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nivel_entrenamiento_id">Nivel de Entrenamiento</label>
                                        <select class="form-control @error('nivel_entrenamiento_id') is-invalid @enderror"
                                            id="nivel_entrenamiento_id" name="nivel_entrenamiento_id">
                                            <option value="">Seleccione...</option>
                                            @foreach ($nivelesEntrenamiento as $nivel)
                                                <option value="{{ $nivel->id }}"
                                                    {{ old('nivel_entrenamiento_id', $usuario->nivel_entrenamiento_id) == $nivel->id ? 'selected' : '' }}>
                                                    {{ $nivel->nivel }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('nivel_entrenamiento_id')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="entidad_perteneciente">Entidad Perteneciente</label>
                                        <input type="text"
                                            class="form-control @error('entidad_perteneciente') is-invalid @enderror"
                                            id="entidad_perteneciente" name="entidad_perteneciente"
                                            value="{{ old('entidad_perteneciente', $usuario->entidad_perteneciente) }}">
                                        @error('entidad_perteneciente')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <h5 class="mb-3 mt-4"><i class="fas fa-cog"></i> Configuración del Sistema</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="rol_id">Rol <span class="text-danger">*</span></label>
                                        <select class="form-control @error('rol_id') is-invalid @enderror" id="rol_id"
                                            name="rol_id" required>
                                            <option value="">Seleccione...</option>
                                            @foreach ($roles as $rol)
                                                <option value="{{ $rol->id }}"
                                                    {{ old('rol_id', $usuario->rol_id) == $rol->id ? 'selected' : '' }}>
                                                    {{ $rol->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('rol_id')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="estado_id">Estado <span class="text-danger">*</span></label>
                                        <select class="form-control @error('estado_id') is-invalid @enderror"
                                            id="estado_id" name="estado_id" required>
                                            <option value="">Seleccione...</option>
                                            @foreach ($estados as $estado)
                                                <option value="{{ $estado->id }}"
                                                    {{ old('estado_id', $usuario->estado_id) == $estado->id ? 'selected' : '' }}>
                                                    {{ $estado->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('estado_id')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Guardar Cambios
                            </button>
                            <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
