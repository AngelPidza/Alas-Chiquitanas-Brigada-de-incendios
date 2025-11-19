@extends('adminlte::page')

@section('title', 'Niveles de Entrenamiento')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Niveles de Entrenamiento</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="#">Catálogos</a></li>
                    <li class="breadcrumb-item active">Niveles de Entrenamiento</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Listado de Niveles de Entrenamiento</h3>
                <div class="card-tools">
                    <a href="{{ route('niveles-entrenamiento.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Nuevo Nivel
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table id="niveles-table" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="80px">Orden</th>
                            <th>Nivel</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th width="150px">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($niveles as $nivel)
                            <tr>
                                <td class="text-center">
                                    <span class="badge badge-secondary">{{ $nivel->orden }}</span>
                                </td>
                                <td><strong>{{ $nivel->nivel }}</strong></td>
                                <td>{{ $nivel->descripcion }}</td>
                                <td>
                                    @if($nivel->activo)
                                        <span class="badge badge-success">Activo</span>
                                    @else
                                        <span class="badge badge-danger">Inactivo</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('niveles-entrenamiento.edit', $nivel->id) }}"
                                       class="btn btn-sm btn-info"
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('niveles-entrenamiento.destroy', $nivel->id) }}"
                                          method="POST"
                                          style="display: inline-block;"
                                          class="form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-danger"
                                                title="Eliminar">
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
            $('#niveles-table').DataTable({
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json'
                },
                order: [[0, 'asc']]
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
