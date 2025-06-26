@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4 text-primary">Editar Hábito</h2>

    <div class="card shadow-sm">
        <div class="card-header bg-warning text-dark">
            Modificar datos del hábito del día {{ \Carbon\Carbon::parse($habito->fecha)->format('d/m/Y') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('habitos.update', $habito->id) }}" class="row g-3">
                @csrf
                @method('PUT')

                <div class="col-md-3">
                    <label class="form-label">Fecha</label>
                    <input type="date" name="fecha" value="{{ $habito->fecha }}" class="form-control" required>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Agua (L)</label>
                    <input type="number" step="0.1" name="agua" value="{{ $habito->agua }}" class="form-control">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Sueño (h)</label>
                    <input type="number" step="0.1" name="sueno" value="{{ $habito->sueno }}" class="form-control">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Ejercicio (min)</label>
                    <input type="number" name="actividad_fisica" value="{{ $habito->actividad_fisica }}" class="form-control">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Alimentación</label>
                    <input type="text" name="alimentacion" value="{{ $habito->alimentacion }}" class="form-control">
                </div>

                <div class="col-12 d-flex justify-content-between mt-3">
                    <a href="{{ route('habitos.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
