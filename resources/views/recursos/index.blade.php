@extends('layouts.app')

@section('title', 'Recursos')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Recursos</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Recursos</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-toolbox mr-1"></i>
                            Listado de Recursos
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover m-0">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Tipo</th>
                                        <th>Estado</th>
                                        <th>Cantidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recursos as $recurso)
                                        <tr>
                                            <td>
                                                <strong>{{ $recurso->descripcion }}</strong>
                                            </td>
                                            <td>
                                                @if ($recurso->tipos_recurso)
                                                    <span
                                                        class="badge badge-info">{{ $recurso->tipos_recurso->nombre }}</span>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($recurso->estados_sistema)
                                                    <span class="badge"
                                                        style="background-color: {{ $recurso->estados_sistema->color ?? '#6c757d' }}; color: white;">
                                                        {{ $recurso->estados_sistema->nombre }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>{{ $recurso->cantidad ?? 0 }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-3">
                                                No hay recursos registrados
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($recursos->hasPages())
            <div class="row mt-3">
                <div class="col-md-12">
                    {{ $recursos->links() }}
                </div>
            </div>
        @endif
    </div>
@stop
