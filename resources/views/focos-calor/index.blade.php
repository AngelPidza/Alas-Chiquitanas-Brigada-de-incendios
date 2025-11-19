@extends('adminlte::page')

@section('title', 'Focos de Calor')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Focos de Calor</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Focos de Calor</li>
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
                            <i class="fas fa-fire mr-1"></i>
                            Listado de Focos de Calor
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('focos-calor.mapa') }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-map"></i> Ver Mapa
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover m-0">
                                <thead>
                                    <tr>
                                        <th>Latitud</th>
                                        <th>Longitud</th>
                                        <th>Confianza</th>
                                        <th>Fecha</th>
                                        <th>Satélite</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($focos as $foco)
                                        <tr>
                                            <td>{{ $foco->latitude }}</td>
                                            <td>{{ $foco->longitude }}</td>
                                            <td>
                                                <span class="badge badge-success">{{ $foco->confidence }}%</span>
                                            </td>
                                            <td>{{ $foco->acq_date->format('d/m/Y H:i') }}</td>
                                            <td>{{ $foco->satellite ?? 'N/A' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-3">
                                                No hay focos de calor registrados
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

        @if ($focos->hasPages())
            <div class="row mt-3">
                <div class="col-md-12">
                    {{ $focos->links() }}
                </div>
            </div>
        @endif
    </div>
@stop
