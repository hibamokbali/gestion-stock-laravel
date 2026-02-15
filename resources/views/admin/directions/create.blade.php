@extends('layouts.app-stock')

@section('title', 'Créer une Direction')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="table-card">
            <div class="mb-4">
                <h5 class="fw-bold">
                    <i class="bi bi-building text-primary me-2"></i>Nouvelle Direction
                </h5>
            </div>

            <form action="{{ route('admin.directions.store') }}" method="POST">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Code Direction <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-hash"></i></span>
                            <input type="text" name="code_direction" class="form-control @error('code_direction') is-invalid @enderror" value="{{ old('code_direction') }}" placeholder="Ex: DIR-001" required>
                        </div>
                        @error('code_direction')
                        <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nom Direction <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-building"></i></span>
                            <input type="text" name="nom_direction" class="form-control @error('nom_direction') is-invalid @enderror" value="{{ old('nom_direction') }}" placeholder="Ex: Direction des Ressources Humaines" required>
                        </div>
                        @error('nom_direction')
                        <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                        @enderror
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.directions.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle me-2"></i>Annuler
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-2"></i>Créer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection