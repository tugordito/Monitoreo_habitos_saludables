@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Reporte Semanal de Hábitos</h2>

    <!-- Estadísticas -->
    <div class="mb-4">
        <h4>Estadísticas</h4>
        <ul>
            <li><strong>Días registrados:</strong> {{ count($labels) }}</li>
            <li><strong>Promedio de agua:</strong> {{ number_format(collect($agua)->avg(), 2) }} L</li>
            <li><strong>Promedio de sueño:</strong> {{ number_format(collect($sueno)->avg(), 2) }} h</li>
            <li><strong>Promedio de ejercicio:</strong> {{ number_format(collect($ejercicio)->avg(), 0) }} min</li>
        </ul>
    </div>

    <!-- Gráfico -->
    <div style="max-width: 600px; margin: 0 auto;">
    <canvas id="habitosChart"></canvas>
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
            @foreach($habitos as $h)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($h->fecha)->format('d/m/Y') }}</td>
                    <td>{{ $h->agua }} L</td>
                    <td>{{ $h->sueno }} h</td>
                    <td>{{ $h->actividad_fisica }} min</td>
                    <td>{{ $h->alimentacion }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('habitosChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($labels),
            datasets: [
                {
                    label: 'Agua (L)',
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    data: @json($agua)
                },
                {
                    label: 'Sueño (h)',
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    data: @json($sueno)
                },
                {
                    label: 'Ejercicio (min)',
                    backgroundColor: 'rgba(255, 159, 64, 0.6)',
                    data: @json($ejercicio)
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
