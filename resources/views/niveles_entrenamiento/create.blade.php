@extends('layouts.app')

@section('title', 'Nuevo Nivel de Entrenamiento')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Nuevo Nivel de Entrenamiento</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('niveles_entrenamiento.index') }}">Niveles de
                            Entrenamiento</a></li>
                    <li class="breadcrumb-item active">Nuevo</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Formulario de Registro</h3>
                    </div>
                    <form action="{{ route('niveles_entrenamiento.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="nivel">Nivel <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('nivel') is-invalid @enderror"
                                            id="nivel" name="nivel"
                                            placeholder="Ej: Básico, Intermedio, Avanzado, Especializado"
                                            value="{{ old('nivel') }}" required maxlength="50">
                                        @error('nivel')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                        <small class="form-text text-muted">Nombre del nivel de entrenamiento (máx. 50
                                            caracteres)</small>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="orden">Orden <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('orden') is-invalid @enderror"
                                            id="orden" name="orden" placeholder="Ej: 1, 2, 3..."
                                            value="{{ old('orden') }}" required min="1">
                                        @error('orden')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                        <small class="form-text text-muted">Orden de prioridad</small>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion"
                                    rows="3" placeholder="Describe las características y requisitos de este nivel...">{{ old('descripcion') }}</textarea>
                                @error('descripcion')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="activo" name="activo"
                                        value="1" {{ old('activo', true) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="activo">Activo</label>
                                </div>
                                <small class="form-text text-muted">Si está activo, estará disponible para su uso en el
                                    sistema</small>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Guardar
                            </button>
                            <a href="{{ route('niveles_entrenamiento.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
