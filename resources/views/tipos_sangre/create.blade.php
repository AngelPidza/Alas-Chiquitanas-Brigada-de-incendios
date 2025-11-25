@extends('layouts.app')

@section('title', 'Nuevo Tipo de Sangre')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Nuevo Tipo de Sangre</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('tipos_sangre.index') }}">Tipos de Sangre</a></li>
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
                    <form action="{{ route('tipos_sangre.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="codigo">Código <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('codigo') is-invalid @enderror"
                                    id="codigo" name="codigo" placeholder="Ej: A+, B-, O+, AB-"
                                    value="{{ old('codigo') }}" required maxlength="5">
                                @error('codigo')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="form-text text-muted">Código único para identificar el tipo de sangre (máx. 5
                                    caracteres)</small>
                            </div>

                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <input type="text" class="form-control @error('descripcion') is-invalid @enderror"
                                    id="descripcion" name="descripcion" placeholder="Ej: Tipo A positivo, Tipo O negativo"
                                    value="{{ old('descripcion') }}" maxlength="50">
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
                            <a href="{{ route('tipos_sangre.index') }}" class="btn btn-secondary">
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
