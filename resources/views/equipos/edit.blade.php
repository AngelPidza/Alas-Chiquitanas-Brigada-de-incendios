@extends('layouts.app')

@section('title', 'Editar Equipo')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Editar Equipo</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('equipos.index') }}">Equipos</a></li>
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
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-users mr-1"></i>
                            Información del Equipo
                        </h3>
                    </div>
                    <form action="{{ route('equipos.update', $equipo->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <h5><i class="icon fas fa-ban"></i> Errores de validación</h5>
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nombre_equipo">
                                            Nombre del Equipo <span class="text-danger">*</span>
                                        </label>
                                        <input type="text"
                                            class="form-control @error('nombre_equipo') is-invalid @enderror"
                                            id="nombre_equipo" name="nombre_equipo"
                                            value="{{ old('nombre_equipo', $equipo->nombre_equipo) }}"
                                            placeholder="Ej: Equipo Alpha" required>
                                        @error('nombre_equipo')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="estado_id">
                                            Estado <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control @error('estado_id') is-invalid @enderror" id="estado_id"
                                            name="estado_id" required>
                                            <option value="">Seleccione un estado</option>
                                            @foreach ($estados as $estado)
                                                <option value="{{ $estado->id }}"
                                                    {{ old('estado_id', $equipo->estado_id) == $estado->id ? 'selected' : '' }}>
                                                    {{ $estado->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('estado_id')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="mb-3">Ubicación GPS (Opcional)</h5>
                                    <p class="text-muted">Haga clic en el mapa para establecer la ubicación del equipo</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div id="map" style="height: 400px; border-radius: 0.25rem;"></div>
                                        <small class="form-text text-muted mt-2">
                                            <i class="fas fa-info-circle"></i> Haga clic en el mapa para colocar el marcador
                                            de ubicación o arrastre el marcador existente
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="latitud">
                                            Latitud
                                        </label>
                                        <input type="number" class="form-control @error('latitud') is-invalid @enderror"
                                            id="latitud" name="latitud" value="{{ old('latitud', $latitud) }}"
                                            step="0.000001" min="-90" max="90" placeholder="-16.5000"
                                            style="background-color: #e9ecef;">
                                        @error('latitud')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="longitud">
                                            Longitud
                                        </label>
                                        <input type="number" class="form-control @error('longitud') is-invalid @enderror"
                                            id="longitud" name="longitud" value="{{ old('longitud', $longitud) }}"
                                            step="0.000001" min="-180" max="180" placeholder="-64.5000"
                                            style="background-color: #e9ecef;">
                                        @error('longitud')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-info">
                                        <i class="icon fas fa-info-circle"></i>
                                        <strong>Integrantes actuales:</strong> {{ $equipo->cantidad_integrantes ?? 0 }}
                                        <br>
                                        <small>La cantidad de integrantes se actualiza automáticamente al agregar o remover
                                            miembros.</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Actualizar Equipo
                            </button>
                            <a href="{{ route('equipos.index') }}" class="btn btn-secondary">
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
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@stop

@section('js')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        let map, marker;

        document.addEventListener('DOMContentLoaded', function() {
            // Obtener coordenadas existentes del equipo
            const existingLat = parseFloat(document.getElementById('latitud').value) || -16.5000;
            const existingLng = parseFloat(document.getElementById('longitud').value) || -64.5000;
            const hasExistingLocation = document.getElementById('latitud').value && document.getElementById(
                'longitud').value;

            // Inicializar el mapa con la ubicación existente o por defecto
            const initialZoom = hasExistingLocation ? 13 : 6;
            map = L.map('map').setView([existingLat, existingLng], initialZoom);

            // Agregar capa de OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 19
            }).addTo(map);

            // Si hay ubicación existente, crear marcador
            if (hasExistingLocation) {
                marker = L.marker([existingLat, existingLng], {
                    draggable: true
                }).addTo(map);

                // Actualizar coordenadas al arrastrar el marcador
                marker.on('dragend', function(e) {
                    const position = marker.getLatLng();
                    updateCoordinates(position.lat, position.lng);
                });
            }

            // Evento de clic en el mapa
            map.on('click', function(e) {
                const lat = e.latlng.lat;
                const lng = e.latlng.lng;

                // Si ya existe un marcador, moverlo
                if (marker) {
                    marker.setLatLng([lat, lng]);
                } else {
                    // Crear nuevo marcador draggable
                    marker = L.marker([lat, lng], {
                        draggable: true
                    }).addTo(map);

                    // Actualizar coordenadas al arrastrar
                    marker.on('dragend', function(e) {
                        const position = marker.getLatLng();
                        updateCoordinates(position.lat, position.lng);
                    });
                }

                updateCoordinates(lat, lng);
            });

            // Función para actualizar los campos de coordenadas
            function updateCoordinates(lat, lng) {
                const latInput = document.getElementById('latitud');
                const lngInput = document.getElementById('longitud');
                latInput.value = lat.toFixed(6);
                lngInput.value = lng.toFixed(6);

                // Hacer readonly para evitar edición manual
                latInput.setAttribute('readonly', 'readonly');
                lngInput.setAttribute('readonly', 'readonly');
            }

            // Si hay ubicación inicial, marcar campos como readonly
            if (hasExistingLocation) {
                document.getElementById('latitud').setAttribute('readonly', 'readonly');
                document.getElementById('longitud').setAttribute('readonly', 'readonly');
            }

            // Prevenir edición manual de los campos
            document.getElementById('latitud').addEventListener('focus', function() {
                this.blur();
            });
            document.getElementById('longitud').addEventListener('focus', function() {
                this.blur();
            });

            // Botón para obtener ubicación actual
            const locationControl = L.Control.extend({
                options: {
                    position: 'topleft'
                },
                onAdd: function(map) {
                    const container = L.DomUtil.create('div',
                        'leaflet-bar leaflet-control leaflet-control-custom');
                    container.innerHTML =
                        '<a href="#" title="Usar mi ubicación actual" style="background-color: white; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; font-size: 18px;"><i class="fas fa-crosshairs"></i></a>';

                    container.onclick = function(e) {
                        e.preventDefault();
                        e.stopPropagation();

                        if (navigator.geolocation) {
                            container.style.opacity = '0.5';
                            navigator.geolocation.getCurrentPosition(
                                function(position) {
                                    const lat = position.coords.latitude;
                                    const lng = position.coords.longitude;

                                    map.setView([lat, lng], 13);

                                    if (marker) {
                                        marker.setLatLng([lat, lng]);
                                    } else {
                                        marker = L.marker([lat, lng], {
                                            draggable: true
                                        }).addTo(map);

                                        marker.on('dragend', function(e) {
                                            const position = marker.getLatLng();
                                            updateCoordinates(position.lat, position
                                                .lng);
                                        });
                                    }

                                    updateCoordinates(lat, lng);
                                    container.style.opacity = '1';
                                },
                                function(error) {
                                    alert('Error al obtener la ubicación: ' + error.message);
                                    container.style.opacity = '1';
                                }
                            );
                        } else {
                            alert('Su navegador no soporta geolocalización');
                        }
                    };

                    return container;
                }
            });

            map.addControl(new locationControl());
        });
    </script>
@stop
