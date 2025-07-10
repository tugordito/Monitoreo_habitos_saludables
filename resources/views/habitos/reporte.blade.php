@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Reporte de Hábitos</h2>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Filtros</h5>
            <form method="GET" action="{{ route('habitos.reporte') }}">
                <div class="row">
                    <div class="col-md-4">
                        <label for="periodo" class="form-label">Período</label>
                        <select name="periodo" id="periodo" class="form-select">
                            <option value="semana" {{ request('periodo') == 'semana' ? 'selected' : '' }}>Esta Semana</option>
                            <option value="mes" {{ request('periodo') == 'mes' ? 'selected' : '' }}>Este Mes</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="fecha" class="form-label">Fecha específica</label>
                        <input type="date" name="fecha" id="fecha" class="form-control" value="{{ request('fecha') }}">
                        <small class="text-muted">Para semana: cualquier día de esa semana. Para mes: cualquier día de ese mes.</small>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">Filtrar</button>
                        <a href="{{ route('habitos.reporte') }}" class="btn btn-secondary">Limpiar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Información del período -->
    <div class="alert alert-info">
        <strong>Mostrando:</strong> {{ $periodoTexto }}
        <br><strong>Rango:</strong> {{ $fechaInicio }} - {{ $fechaFin }}
    </div>

    <!-- Estadísticas -->
    <div class="mb-4">
        <h4>Estadísticas</h4>
        <div class="row">
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">{{ count($labels) }}</h5>
                        <p class="card-text">Días registrados</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">{{ number_format(collect($agua)->avg(), 2) }} L</h5>
                        <p class="card-text">Promedio de agua</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">{{ number_format(collect($sueno)->avg(), 2) }} h</h5>
                        <p class="card-text">Promedio de sueño</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">{{ number_format(collect($ejercicio)->avg(), 0) }} min</h5>
                        <p class="card-text">Promedio de ejercicio</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráfico -->
    <div class="mb-4">
        <h4>Gráfico de Progreso</h4>
        <div style="max-width: 800px; margin: 0 auto;">
            <canvas id="habitosChart"></canvas>
        </div>
    </div>

    <!-- Tabla de datos -->
    <h4>Datos detallados</h4>
    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>Fecha</th>
                <th>Agua</th>
                <th>Sueño</th>
                <th>Ejercicio</th>
                <th>Alimentación</th>
            </tr>
        </thead>
        <tbody>
            @forelse($habitos as $h)
            <tr>
                <td>{{ \Carbon\Carbon::parse($h->fecha)->format('d/m/Y') }}</td>
                <td>{{ $h->agua }} L</td>
                <td>{{ $h->sueno }} h</td>
                <td>{{ $h->actividad_fisica }} min</td>
                <td>{{ $h->alimentacion }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">No hay datos para el período seleccionado</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('habitosChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($labels),
            datasets: [{
                    label: 'Agua (L)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    data: @json($agua),
                    tension: 0.1
                },
                {
                    label: 'Sueño (h)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    data: @json($sueno),
                    tension: 0.1
                },
                {
                    label: 'Ejercicio (min/10)',
                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                    borderColor: 'rgba(255, 159, 64, 1)',
                    data: @json(collect($ejercicio)->map(fn($val) => $val / 10)),
                    tension: 0.1
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Cantidad'
                    }
                }
            }
        }
    });
</script>
@endsection