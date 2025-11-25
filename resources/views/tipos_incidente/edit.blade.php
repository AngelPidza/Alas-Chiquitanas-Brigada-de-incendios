@extends('layouts.app')

@section('title', 'Editar Tipo de Incidente')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Editar Tipo de Incidente</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('tipos_incidente.index') }}">Tipos de Incidente</a></li>
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
                    <form action="{{ route('tipos_incidente.update', $tipo->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="codigo">Código <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('codigo') is-invalid @enderror"
                                            id="codigo" name="codigo" value="{{ old('codigo', $tipo->codigo) }}"
                                            required maxlength="50">
                                        @error('codigo')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="nombre">Nombre <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                                            id="nombre" name="nombre" value="{{ old('nombre', $tipo->nombre) }}"
                                            required maxlength="100">
                                        @error('nombre')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion"
                                    rows="3">{{ old('descripcion', $tipo->descripcion) }}</textarea>
                                @error('descripcion')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="icono">Icono (FontAwesome)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i id="icon-preview" class="fas fa-{{ $tipo->icono ?? 'fire' }}"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control @error('icono') is-invalid @enderror"
                                                id="icono" name="icono" value="{{ old('icono', $tipo->icono) }}"
                                                maxlength="50">
                                            @error('icono')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <small class="form-text text-muted">
                                            Nombre del icono FontAwesome sin el prefijo "fa-".
                                            <a href="https://fontawesome.com/icons" target="_blank">Ver iconos
                                                disponibles</a>
                                        </small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="color">Color (Hexadecimal)</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control @error('color') is-invalid @enderror"
                                                id="color" name="color"
                                                value="{{ old('color', $tipo->color ?? '#dc3545') }}"
                                                style="max-width: 80px;">
                                            <input type="text" class="form-control" id="color-text"
                                                value="{{ old('color', $tipo->color ?? '#dc3545') }}" readonly>
                                            @error('color')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="activo" name="activo"
                                        value="1" {{ old('activo', $tipo->activo) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="activo">Activo</label>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save"></i> Actualizar
                            </button>
                            <a href="{{ route('tipos_incidente.index') }}" class="btn btn-secondary">
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
            // Sincronizar el color picker con el input de texto
            $('#color').on('input', function() {
                $('#color-text').val($(this).val());
                $('#icon-preview').css('color', $(this).val());
            });

            // Actualizar preview del icono
            $('#icono').on('input', function() {
                const iconName = $(this).val();
                $('#icon-preview').attr('class', 'fas fa-' + iconName);
            });

            // Inicializar color del icono
            $('#icon-preview').css('color', $('#color').val());
        });
    </script>
@stop
