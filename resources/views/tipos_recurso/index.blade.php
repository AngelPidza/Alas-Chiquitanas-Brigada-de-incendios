@extends('adminlte::page')

@section('title', 'Tipos de Recurso')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Tipos de Recurso</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="#">Catálogos</a></li>
                    <li class="breadcrumb-item active">Tipos de Recurso</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Listado de Tipos de Recurso</h3>
                <div class="card-tools">
                    <a href="{{ route('tipos-recurso.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Nuevo Tipo
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table id="tipos-recurso-table" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="100px">Código</th>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Unidad de Medida</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th width="150px">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tipos as $tipo)
                            <tr>
                                <td><strong>{{ $tipo->codigo }}</strong></td>
                                <td>{{ $tipo->nombre }}</td>
                                <td>
                                    @if ($tipo->categoria)
                                        <span class="badge badge-info">{{ $tipo->categoria }}</span>
                                    @else
                                        <span class="text-muted">Sin categoría</span>
                                    @endif
                                </td>
                                <td>{{ $tipo->unidad_medida ?? 'N/A' }}</td>
                                <td>{{ $tipo->descripcion }}</td>
                                <td>
                                    @if ($tipo->activo)
                                        <span class="badge badge-success">Activo</span>
                                    @else
                                        <span class="badge badge-danger">Inactivo</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('tipos-recurso.edit', $tipo->id) }}" class="btn btn-sm btn-info"
                                        title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('tipos-recurso.destroy', $tipo->id) }}" method="POST"
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
            $('#tipos-recurso-table').DataTable({
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json'
                },
                order: [
                    [2, 'asc'],
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
