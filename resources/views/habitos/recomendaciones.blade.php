@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4 text-primary">Recomendaciones Personalizadas</h2>

    @if(count($recomendaciones))
        <div class="row">
            @foreach($recomendaciones as $reco)
                <div class="col-md-6 mb-3">
                    <div class="card border-info shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="me-3">
                                <i class="bi bi-info-circle-fill text-info fs-3"></i>
                            </div>
                            <div>
                                <p class="mb-0">{{ $reco }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-success text-center shadow-sm" role="alert">
            🎉 ¡Buen trabajo! No hay recomendaciones por ahora.
        </div>
    @endif
</div>
@endsection
