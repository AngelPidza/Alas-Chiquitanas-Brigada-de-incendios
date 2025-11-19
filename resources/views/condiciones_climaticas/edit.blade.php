@extends('adminlte::page')

@section('title', 'Editar Condición Climática')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Editar Condición Climática</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('condiciones-climaticas.index') }}">Condiciones Climáticas</a></li>
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
                    <form action="{{ route('condiciones-climaticas.update', $condicion->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="codigo">Código <span class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control @error('codigo') is-invalid @enderror"
                                               id="codigo"
                                               name="codigo"
                                               value="{{ old('codigo', $condicion->codigo) }}"
                                               required
                                               maxlength="50">
                                        @error('codigo')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="nombre">Nombre <span class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control @error('nombre') is-invalid @enderror"
                                               id="nombre"
                                               name="nombre"
                                               value="{{ old('nombre', $condicion->nombre) }}"
                                               required
                                               maxlength="100">
                                        @error('nombre')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <textarea class="form-control @error('descripcion') is-invalid @enderror"
                                          id="descripcion"
                                          name="descripcion"
                                          rows="3">{{ old('descripcion', $condicion->descripcion) }}</textarea>
                                @error('descripcion')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="factor_riesgo">Factor de Riesgo (1-10)</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="range"
                                               class="custom-range"
                                               id="factor_riesgo"
                                               name="factor_riesgo"
                                               min="1"
                                               max="10"
                                               value="{{ old('factor_riesgo', $condicion->factor_riesgo ?? 5) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input type="number"
                                                   class="form-control @error('factor_riesgo') is-invalid @enderror"
                                                   id="factor_riesgo_value"
                                                   value="{{ old('factor_riesgo', $condicion->factor_riesgo ?? 5) }}"
                                                   readonly
                                                   style="max-width: 80px;">
                                            <div class="input-group-append">
                                                <span class="input-group-text">/10</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <small class="form-text text-muted">
                                    Factor de riesgo para incendios:
                                    <span class="text-success">1-3 (Bajo)</span>,
                                    <span class="text-warning">4-6 (Medio)</span>,
                                    <span class="text-danger">7-10 (Alto)</span>
                                </small>
                                @error('factor_riesgo')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox"
                                           class="custom-control-input"
                                           id="activo"
                                           name="activo"
                                           value="1"
                                           {{ old('activo', $condicion->activo) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="activo">Activo</label>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save"></i> Actualizar
                            </button>
                            <a href="{{ route('condiciones-climaticas.index') }}" class="btn btn-secondary">
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
    <script>
        $(document).ready(function() {
            // Sincronizar el slider con el input de número
            $('#factor_riesgo').on('input', function() {
                $('#factor_riesgo_value').val($(this).val());
            });
        });
    </script>
@stop
