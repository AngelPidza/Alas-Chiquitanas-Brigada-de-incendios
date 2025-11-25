@extends('layouts.app')

@section('title', 'Condiciones Climáticas')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Condiciones Climáticas</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="#">Catálogos</a></li>
                    <li class="breadcrumb-item active">Condiciones Climáticas</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Listado de Condiciones Climáticas</h3>
                <div class="card-tools">
                    <a href="{{ route('condiciones-climaticas.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Nueva Condición
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table id="condiciones-table" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="100px">Código</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th width="150px">Factor de Riesgo</th>
                            <th>Estado</th>
                            <th width="150px">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($condiciones as $condicion)
                            <tr>
                                <td><strong>{{ $condicion->codigo }}</strong></td>
                                <td>{{ $condicion->nombre }}</td>
                                <td>{{ $condicion->descripcion }}</td>
                                <td class="text-center">
                                    @if ($condicion->factor_riesgo)
                                        @php
                                            $color = 'success';
                                            if ($condicion->factor_riesgo >= 7) {
                                                $color = 'danger';
                                            } elseif ($condicion->factor_riesgo >= 4) {
                                                $color = 'warning';
                                            }
                                        @endphp
                                        <div class="progress" style="height: 25px;">
                                            <div class="progress-bar bg-{{ $color }}" role="progressbar"
                                                style="width: {{ $condicion->factor_riesgo * 10 }}%"
                                                aria-valuenow="{{ $condicion->factor_riesgo }}" aria-valuemin="0"
                                                aria-valuemax="10">
                                                {{ $condicion->factor_riesgo }}/10
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">No definido</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($condicion->activo)
                                        <span class="badge badge-success">Activo</span>
                                    @else
                                        <span class="badge badge-danger">Inactivo</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('condiciones-climaticas.edit', $condicion->id) }}"
                                        class="btn btn-sm btn-info" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('condiciones-climaticas.destroy', $condicion->id) }}"
                                        method="POST" style="display: inline-block;" class="form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Inicializar DataTable
            $('#condiciones-table').DataTable({
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json'
                },
                order: [
                    [0, 'asc']
                ]
            });

            // Confirmación antes de eliminar
            $('.form-delete').on('submit', function(e) {
                e.preventDefault();
                const form = this;

                Swal.fire({
                    title: '¿Está seguro?',
                    text: "Esta acción no se puede revertir",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@stop
