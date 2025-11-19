@extends('adminlte::page')

@section('title', 'Equipos')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Equipos</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Equipos</li>
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
                            <i class="fas fa-users mr-1"></i>
                            Listado de Equipos
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover m-0">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Integrantes</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($equipos as $equipo)
                                        <tr>
                                            <td>
                                                <strong>{{ $equipo->nombre_equipo }}</strong>
                                            </td>
                                            <td>
                                                {{ $equipo->cantidad_integrantes ?? 0 }}
                                            </td>
                                            <td>
                                                @if ($equipo->estados_sistema)
                                                    @switch($equipo->estados_sistema->nombre)
                                                        @case('Activo')
                                                            <span
                                                                class="badge badge-success">{{ $equipo->estados_sistema->nombre }}</span>
                                                        @break

                                                        @case('Inactivo')
                                                            <span
                                                                class="badge badge-secondary">{{ $equipo->estados_sistema->nombre }}</span>
                                                        @break

                                                        @case('Mantenimiento')
                                                            <span
                                                                class="badge badge-warning">{{ $equipo->estados_sistema->nombre }}</span>
                                                        @break

                                                        @default
                                                            <span
                                                                class="badge badge-default">{{ $equipo->estados_sistema->nombre }}</span>
                                                    @endswitch
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted py-3">
                                                    No hay equipos registrados
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

            @if ($equipos->hasPages())
                <div class="row mt-3">
                    <div class="col-md-12">
                        {{ $equipos->links() }}
                    </div>
                </div>
            @endif
        </div>
    @stop
