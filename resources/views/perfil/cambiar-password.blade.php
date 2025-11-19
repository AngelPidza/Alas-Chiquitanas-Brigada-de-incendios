@extends('adminlte::page')

@section('title', 'Cambiar Contraseña')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Cambiar Contraseña</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('perfil') }}">Mi Perfil</a></li>
                    <li class="breadcrumb-item active">Cambiar Contraseña</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6">
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
                    <div class="card-header bg-warning">
                        <h3 class="card-title">
                            <i class="fas fa-key mr-1"></i>
                            Actualizar Contraseña
                        </h3>
                    </div>
                    <form action="{{ route('cambiar-password.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label>Contraseña Actual</label>
                                <div class="input-group">
                                    <input type="password" id="password_actual" name="password_actual"
                                        class="form-control @error('password_actual') is-invalid @enderror" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button"
                                            onclick="togglePassword('password_actual')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('password_actual')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <small class="form-text text-muted">
                                    Por seguridad, debes ingresar tu contraseña actual.
                                </small>
                            </div>

                            <div class="form-group">
                                <label>Contraseña Nueva</label>
                                <div class="input-group">
                                    <input type="password" id="password_nueva" name="password_nueva"
                                        class="form-control @error('password_nueva') is-invalid @enderror" required
                                        minlength="8">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button"
                                            onclick="togglePassword('password_nueva')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('password_nueva')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <small class="form-text text-muted">
                                    Mínimo 8 caracteres.
                                </small>
                            </div>

                            <div class="form-group">
                                <label>Confirmar Contraseña Nueva</label>
                                <div class="input-group">
                                    <input type="password" id="password_nueva_confirmation"
                                        name="password_nueva_confirmation"
                                        class="form-control @error('password_nueva_confirmation') is-invalid @enderror"
                                        required minlength="8">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button"
                                            onclick="togglePassword('password_nueva_confirmation')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('password_nueva_confirmation')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <small class="form-text text-muted">
                                    Debe ser idéntica a la contraseña nueva.
                                </small>
                            </div>

                            <div class="alert alert-info">
                                <i class="fas fa-lightbulb mr-2"></i>
                                <strong>Consejos para una contraseña segura:</strong>
                                <ul class="mb-0 mt-2">
                                    <li>Usa al menos 8 caracteres</li>
                                    <li>Combina mayúsculas, minúsculas, números y símbolos</li>
                                    <li>No uses información personal fácil de adivinar</li>
                                    <li>No reutilices contraseñas antiguas</li>
                                </ul>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check mr-1"></i>
                                Cambiar Contraseña
                            </button>
                            <a href="{{ route('perfil') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left mr-1"></i>
                                Volver
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .input-group-append .btn {
            padding: 0.375rem 0.75rem;
        }
    </style>
@stop

@section('js')
    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            if (field.type === 'password') {
                field.type = 'text';
            } else {
                field.type = 'password';
            }
        }
    </script>
@stop
