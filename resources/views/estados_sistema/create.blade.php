@extends('layouts.app')

@section('title', 'Nuevo Estado del Sistema')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Nuevo Estado del Sistema</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('estados-sistema.index') }}">Estados del Sistema</a></li>
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
                    <form action="{{ route('estados-sistema.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tabla">Tabla <span class="text-danger">*</span></label>
                                        <select class="form-control select2 @error('tabla') is-invalid @enderror"
                                            id="tabla" name="tabla" required style="width: 100%;">
                                            <option value="">Seleccione una tabla</option>
                                            <option value="usuarios" {{ old('tabla') == 'usuarios' ? 'selected' : '' }}>
                                                usuarios</option>
                                            <option value="equipos" {{ old('tabla') == 'equipos' ? 'selected' : '' }}>
                                                equipos</option>
                                            <option value="reportes" {{ old('tabla') == 'reportes' ? 'selected' : '' }}>
                                                reportes</option>
                                            <option value="recursos" {{ old('tabla') == 'recursos' ? 'selected' : '' }}>
                                                recursos</option>
                                        </select>
                                        @error('tabla')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                        <small class="form-text text-muted">Tabla a la que pertenece el estado</small>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="codigo">Código <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('codigo') is-invalid @enderror"
                                            id="codigo" name="codigo" placeholder="Ej: pendiente, activo, finalizado"
                                            value="{{ old('codigo') }}" required maxlength="50">
                                        @error('codigo')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nombre">Nombre <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                                            id="nombre" name="nombre" placeholder="Ej: Pendiente, Activo, Finalizado"
                                            value="{{ old('nombre') }}" required maxlength="100">
                                        @error('nombre')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion"
                                    rows="2" placeholder="Describe las características de este estado...">{{ old('descripcion') }}</textarea>
                                @error('descripcion')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="orden">Orden</label>
                                        <input type="number" class="form-control @error('orden') is-invalid @enderror"
                                            id="orden" name="orden" placeholder="Ej: 1, 2, 3..."
                                            value="{{ old('orden') }}" min="1">
                                        @error('orden')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                        <small class="form-text text-muted">Orden de secuencia</small>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="color">Color (Hexadecimal)</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control @error('color') is-invalid @enderror"
                                                id="color" name="color" value="{{ old('color', '#007bff') }}"
                                                style="max-width: 80px;">
                                            <input type="text" class="form-control" id="color-text"
                                                value="{{ old('color', '#007bff') }}" readonly>
                                            @error('color')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <small class="form-text text-muted">Color para identificar visualmente</small>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Opciones</label>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="es_final"
                                                name="es_final" value="1" {{ old('es_final') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="es_final">Es Estado Final</label>
                                        </div>
                                        <small class="form-text text-muted">Indica si es un estado terminal</small>
                                    </div>
                                </div>
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
                            <a href="{{ route('estados-sistema.index') }}" class="btn btn-secondary">
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
            // Inicializar Select2
            $('.select2').select2({
                theme: 'bootstrap4',
                placeholder: 'Seleccione una opción'
            });

            // Sincronizar el color picker con el input de texto
            $('#color').on('input', function() {
                $('#color-text').val($(this).val());
            });
        });
    </script>
@stop
