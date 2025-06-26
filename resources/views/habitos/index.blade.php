@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4 text-primary">Gestión de Hábitos Diarios</h2>

    <!-- Mensaje de éxito -->
    @if(session('success'))
        <div class="alert alert-success shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Formulario -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            Registrar nuevo hábito
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('habitos.store') }}" class="row g-3">
                @csrf
                <div class="col-md-2">
                    <label class="form-label">Fecha</label>
                    <input type="date" name="fecha" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Agua (L)</label>
                    <input type="number" step="0.1" name="agua" class="form-control" placeholder="Ej: 2.5">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Sueño (h)</label>
                    <input type="number" step="0.1" name="sueno" class="form-control" placeholder="Ej: 7.5">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Ejercicio (min)</label>
                    <input type="number" name="actividad_fisica" class="form-control" placeholder="Ej: 30">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Alimentación</label>
                    <input type="text" name="alimentacion" class="form-control" placeholder="Buena, Regular...">
                </div>
                <div class="col-md-1 d-grid align-items-end">
                    <button type="submit" class="btn btn-success mt-4">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Recomendaciones -->
    @if(isset($recomendaciones))
        @if(count($recomendaciones))
            <div class="mb-4">
                <h4 class="text-info">Recomendaciones para mejorar</h4>
                <div class="row">
                    @foreach($recomendaciones as $reco)
                        <div class="col-md-6 mb-3">
                            <div class="card border-warning shadow-sm">
                                <div class="card-body d-flex align-items-center">
                                    <i class="bi bi-exclamation-circle text-warning fs-4 me-3"></i>
                                    <span>{{ $reco }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="alert alert-success text-center shadow-sm">
                🎉 ¡Todo bien! No hay recomendaciones por ahora.
            </div>
        @endif
    @endif

    <!-- Tabla de hábitos -->
    <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white">
            Hábitos registrados
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Fecha</th>
                            <th>Agua (L)</th>
                            <th>Sueño (h)</th>
                            <th>Ejercicio (min)</th>
                            <th>Alimentación</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($habitos as $habito)
                            <tr>
                                <td>{{ $habito->fecha }}</td>
                                <td>{{ $habito->agua }}</td>
                                <td>{{ $habito->sueno }}</td>
                                <td>{{ $habito->actividad_fisica }}</td>
                                <td>{{ $habito->alimentacion }}</td>
                                <td class="text-end">
                                    <a href="{{ route('habitos.edit', $habito->id) }}" class="btn btn-sm btn-primary">Editar</a>
                                    <form action="{{ route('habitos.destroy', $habito->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('¿Eliminar este hábito?')">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        @if($habitos->isEmpty())
                            <tr>
                                <td colspan="6" class="text-center">Aún no hay hábitos registrados.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
