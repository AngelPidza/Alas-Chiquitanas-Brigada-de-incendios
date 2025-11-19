@extends('adminlte::page')

@section('title', 'Dashboard - Alas Chiquitanas')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        {{-- Info boxes --}}
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-fire"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Incendios Activos</span>
                        <span class="info-box-number">
                            {{ $incendiosActivos ?? 0 }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-bullhorn"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Reportes Pendientes</span>
                        <span class="info-box-number">{{ $reportesPendientes ?? 0 }}</span>
                    </div>
                </div>
            </div>

            <div class="clearfix hidden-md-up"></div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user-friends"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Equipos Desplegados</span>
                        <span class="info-box-number">{{ $equiposDesplegados ?? 0 }}</span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-boxes"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Recursos Solicitados</span>
                        <span class="info-box-number">{{ $recursosSolicitados ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            {{-- Mapa de Operaciones --}}
            <div class="col-md-8">
                <div class="card card-danger">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-map-marked-alt mr-1"></i>
                            Mapa de Operaciones
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="map" style="height: 400px; width: 100%;"></div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-3 col-6">
                                <div class="description-block border-right">
                                    <span class="description-percentage text-danger"><i class="fas fa-fire"></i></span>
                                    <h5 class="description-header">{{ $focosCalor ?? 0 }}</h5>
                                    <span class="description-text">FOCOS DE CALOR</span>
                                </div>
                            </div>
                            <div class="col-sm-3 col-6">
                                <div class="description-block border-right">
                                    <span class="description-percentage text-warning"><i class="fas fa-bullhorn"></i></span>
                                    <h5 class="description-header">{{ $reportesHoy ?? 0 }}</h5>
                                    <span class="description-text">REPORTES HOY</span>
                                </div>
                            </div>
                            <div class="col-sm-3 col-6">
                                <div class="description-block border-right">
                                    <span class="description-percentage text-success"><i class="fas fa-check"></i></span>
                                    <h5 class="description-header">{{ $incendiosControlados ?? 0 }}</h5>
                                    <span class="description-text">CONTROLADOS</span>
                                </div>
                            </div>
                            <div class="col-sm-3 col-6">
                                <div class="description-block">
                                    <span class="description-percentage text-info"><i class="fas fa-users"></i></span>
                                    <h5 class="description-header">{{ $bomberosActivos ?? 0 }}</h5>
                                    <span class="description-text">BOMBEROS ACTIVOS</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Reportes Recientes --}}
            <div class="col-md-4">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-bell mr-1"></i>
                            Reportes Recientes
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <ul class="nav nav-pills flex-column">
                            @forelse($reportesRecientes ?? [] as $reporte)
                                <li class="nav-item">
                                    <a href="{{ route('reportes.show', $reporte->id) }}" class="nav-link">
                                        <i class="fas fa-fire text-danger"></i>
                                        {{ Str::limit($reporte->nombre_lugar ?? 'Sin ubicación', 30) }}
                                        <span
                                            class="float-right text-muted text-sm">{{ $reporte->creado?->diffForHumans() ?? 'Sin fecha' }}</span>
                                    </a>
                                </li>
                            @empty
                                <li class="nav-item p-3 text-center text-muted">
                                    <i class="fas fa-inbox fa-2x mb-2"></i>
                                    <p>No hay reportes recientes</p>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('reportes.index') }}" class="btn btn-sm btn-warning">Ver Todos los Reportes</a>
                    </div>
                </div>

                {{-- Noticias Recientes --}}
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-newspaper mr-1"></i>
                            Últimas Noticias
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <ul class="nav nav-pills flex-column">
                            @forelse($noticiasRecientes ?? [] as $noticia)
                                <li class="nav-item">
                                    <a href="{{ route('noticias.show', $noticia->id) }}" class="nav-link">
                                        <i class="fas fa-newspaper text-info"></i> {{ Str::limit($noticia->title, 30) }}
                                        <span
                                            class="float-right text-muted text-sm">{{ $noticia->date->format('d/m') }}</span>
                                    </a>
                                </li>
                            @empty
                                <li class="nav-item p-3 text-center text-muted">
                                    <i class="fas fa-inbox fa-2x mb-2"></i>
                                    <p>No hay noticias</p>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('noticias.index') }}" class="btn btn-sm btn-info">Ver Todas las Noticias</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Gráficos de Estadísticas --}}
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-line mr-1"></i>
                            Incendios por Mes
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="incendiosPorMes" style="height: 300px;"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Tipos de Incidente
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="tiposIncidente" style="height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Equipos y Estado --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header border-transparent">
                        <h3 class="card-title">
                            <i class="fas fa-user-friends mr-1"></i>
                            Estado de Equipos
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table m-0">
                                <thead>
                                    <tr>
                                        <th>Equipo</th>
                                        <th>Integrantes</th>
                                        <th>Ubicación</th>
                                        <th>Estado</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($equipos ?? [] as $equipo)
                                        <tr>
                                            <td><a
                                                    href="{{ route('equipos.show', $equipo->id) }}">{{ $equipo->nombre_equipo }}</a>
                                            </td>
                                            <td>{{ $equipo->cantidad_integrantes }}</td>
                                            <td>
                                                @if ($equipo->ubicacion)
                                                    <span class="badge badge-success">
                                                        <i class="fas fa-map-marker-alt"></i> Ubicación registrada
                                                    </span>
                                                @else
                                                    <span class="badge badge-secondary">Sin ubicación</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($equipo->estados_sistema)
                                                    <span class="badge"
                                                        style="background-color: {{ $equipo->estados_sistema->color ?? '#6c757d' }}">
                                                        {{ $equipo->estados_sistema->nombre }}
                                                    </span>
                                                @else
                                                    <span class="badge badge-secondary">Sin estado</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('equipos.show', $equipo->id) }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-3">
                                                No hay equipos registrados
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer clearfix">
                        <a href="{{ route('equipos.create') }}" class="btn btn-sm btn-info float-left">
                            <i class="fas fa-plus"></i> Nuevo Equipo
                        </a>
                        <a href="{{ route('equipos.index') }}" class="btn btn-sm btn-secondary float-right">
                            Ver Todos los Equipos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        .info-box-number {
            font-size: 2rem;
            font-weight: 700;
        }
    </style>
@stop

@section('js')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Inicializar mapa
        const map = L.map('map').setView([-17.3935, -63.4653], 8); // Santa Cruz, Bolivia

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Agregar marcadores de focos de calor (ejemplo)
        @if (isset($focos) && count($focos) > 0)
            @foreach ($focos as $foco)
                L.marker([{{ $foco->latitude }}, {{ $foco->longitude }}], {
                    icon: L.icon({
                        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
                        iconSize: [25, 41],
                        iconAnchor: [12, 41],
                        popupAnchor: [1, -34],
                        shadowSize: [41, 41]
                    })
                }).addTo(map).bindPopup(
                    'Foco de Calor<br>Confianza: {{ $foco->confidence }}%<br>Fecha: {{ $foco->acq_date }}');
            @endforeach
        @endif

        // Gráfico de Incendios por Mes
        const ctxIncendios = document.getElementById('incendiosPorMes').getContext('2d');
        new Chart(ctxIncendios, {
            type: 'line',
            data: {
                labels: {!! json_encode(
                    $mesesLabels ?? ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                ) !!},
                datasets: [{
                    label: 'Incendios Reportados',
                    data: {!! json_encode($incendiosPorMesData ?? [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]) !!},
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Gráfico de Tipos de Incidente
        const ctxTipos = document.getElementById('tiposIncidente').getContext('2d');
        new Chart(ctxTipos, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($tiposLabels ?? ['Incendio Forestal', 'Incendio Urbano', 'Rescate', 'Otro']) !!},
                datasets: [{
                    data: {!! json_encode($tiposData ?? [65, 20, 10, 5]) !!},
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(255, 159, 64, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(153, 102, 255, 0.8)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
@stop
