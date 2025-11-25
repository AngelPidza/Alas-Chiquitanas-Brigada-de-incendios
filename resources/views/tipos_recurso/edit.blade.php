@extends('layouts.app')

@section('title', 'Editar Tipo de Recurso')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Editar Tipo de Recurso</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('tipos_recurso.index') }}">Tipos de Recurso</a></li>
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
                    <form action="{{ route('tipos_recurso.update', $tipo->id) }}" method="POST">
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

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="categoria">Categoría</label>
                                        <select class="form-control select2 @error('categoria') is-invalid @enderror"
                                            id="categoria" name="categoria" style="width: 100%;">
                                            <option value="">Seleccione una categoría</option>
                                            <option value="Alimentación"
                                                {{ old('categoria', $tipo->categoria) == 'Alimentación' ? 'selected' : '' }}>
                                                Alimentación</option>
                                            <option value="Agua"
                                                {{ old('categoria', $tipo->categoria) == 'Agua' ? 'selected' : '' }}>Agua
                                            </option>
                                            <option value="Medicamentos"
                                                {{ old('categoria', $tipo->categoria) == 'Medicamentos' ? 'selected' : '' }}>
                                                Medicamentos</option>
                                            <option value="Equipo de Protección"
                                                {{ old('categoria', $tipo->categoria) == 'Equipo de Protección' ? 'selected' : '' }}>
                                                Equipo de Protección</option>
                                            <option value="Herramientas"
                                                {{ old('categoria', $tipo->categoria) == 'Herramientas' ? 'selected' : '' }}>
                                                Herramientas</option>
                                            <option value="Combustible"
                                                {{ old('categoria', $tipo->categoria) == 'Combustible' ? 'selected' : '' }}>
                                                Combustible</option>
                                            <option value="Vehículos"
                                                {{ old('categoria', $tipo->categoria) == 'Vehículos' ? 'selected' : '' }}>
                                                Vehículos</option>
                                            <option value="Comunicación"
                                                {{ old('categoria', $tipo->categoria) == 'Comunicación' ? 'selected' : '' }}>
                                                Comunicación</option>
                                            <option value="Otros"
                                                {{ old('categoria', $tipo->categoria) == 'Otros' ? 'selected' : '' }}>Otros
                                            </option>
                                        </select>
                                        @error('categoria')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="unidad_medida">Unidad de Medida</label>
                                        <select class="form-control select2 @error('unidad_medida') is-invalid @enderror"
                                            id="unidad_medida" name="unidad_medida" style="width: 100%;">
                                            <option value="">Seleccione una unidad</option>
                                            <option value="Unidad"
                                                {{ old('unidad_medida', $tipo->unidad_medida) == 'Unidad' ? 'selected' : '' }}>
                                                Unidad</option>
                                            <option value="Litros"
                                                {{ old('unidad_medida', $tipo->unidad_medida) == 'Litros' ? 'selected' : '' }}>
                                                Litros</option>
                                            <option value="Kilogramos"
                                                {{ old('unidad_medida', $tipo->unidad_medida) == 'Kilogramos' ? 'selected' : '' }}>
                                                Kilogramos</option>
                                            <option value="Cajas"
                                                {{ old('unidad_medida', $tipo->unidad_medida) == 'Cajas' ? 'selected' : '' }}>
                                                Cajas</option>
                                            <option value="Galones"
                                                {{ old('unidad_medida', $tipo->unidad_medida) == 'Galones' ? 'selected' : '' }}>
                                                Galones</option>
                                            <option value="Metros"
                                                {{ old('unidad_medida', $tipo->unidad_medida) == 'Metros' ? 'selected' : '' }}>
                                                Metros</option>
                                            <option value="Paquetes"
                                                {{ old('unidad_medida', $tipo->unidad_medida) == 'Paquetes' ? 'selected' : '' }}>
                                                Paquetes</option>
                                        </select>
                                        @error('unidad_medida')
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
                            <a href="{{ route('tipos_recurso.index') }}" class="btn btn-secondary">
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
                placeholder: 'Seleccione una opción',
                allowClear: true
            });
        });
    </script>
@stop
