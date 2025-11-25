@extends('layouts.app')

@section('title', 'Estados del Sistema')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Estados del Sistema</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="#">Catálogos</a></li>
                    <li class="breadcrumb-item active">Estados del Sistema</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Listado de Estados del Sistema</h3>
                <div class="card-tools">
                    <a href="{{ route('estados-sistema.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Nuevo Estado
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table id="estados-table" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="120px">Tabla</th>
                            <th width="100px">Código</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th width="80px">Orden</th>
                            <th width="80px">Color</th>
                            <th width="80px">Final</th>
                            <th>Estado</th>
                            <th width="150px">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($estados as $estado)
                            <tr>
                                <td><span class="badge badge-secondary">{{ $estado->tabla }}</span></td>
                                <td><strong>{{ $estado->codigo }}</strong></td>
                                <td>{{ $estado->nombre }}</td>
                                <td>{{ $estado->descripcion }}</td>
                                <td class="text-center">{{ $estado->orden ?? 'N/A' }}</td>
                                <td class="text-center">
                                    @if ($estado->color)
                                        <span class="badge" style="background-color: {{ $estado->color }}; color: white;">
                                            {{ $estado->color }}
                                        </span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($estado->es_final)
                                        <i class="fas fa-check-circle text-success"></i>
                                    @else
                                        <i class="fas fa-times-circle text-muted"></i>
                                    @endif
                                </td>
                                <td>
                                    @if ($estado->activo)
                                        <span class="badge badge-success">Activo</span>
                                    @else
                                        <span class="badge badge-danger">Inactivo</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('estados-sistema.edit', $estado->id) }}" class="btn btn-sm btn-info"
                                        title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('estados-sistema.destroy', $estado->id) }}" method="POST"
                                        style="display: inline-block;" class="form-delete">
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
            $('#estados-table').DataTable({
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json'
                },
                order: [
                    [0, 'asc'],
                    [4, 'asc']
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
