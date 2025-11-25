@extends('layouts.app')

@section('title', 'Editar Género')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Editar Género</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('generos.index') }}">Géneros</a></li>
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
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">Formulario de Edición</h3>
                    </div>
                    <form action="{{ route('generos.update', $genero->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="codigo">Código <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('codigo') is-invalid @enderror"
                                    id="codigo" name="codigo" value="{{ old('codigo', $genero->codigo) }}" required
                                    maxlength="20">
                                @error('codigo')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="descripcion">Descripción <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('descripcion') is-invalid @enderror"
                                    id="descripcion" name="descripcion"
                                    value="{{ old('descripcion', $genero->descripcion) }}" required maxlength="50">
                                @error('descripcion')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="activo" name="activo"
                                        value="1" {{ old('activo', $genero->activo) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="activo">Activo</label>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save"></i> Actualizar
                            </button>
                            <a href="{{ route('generos.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
