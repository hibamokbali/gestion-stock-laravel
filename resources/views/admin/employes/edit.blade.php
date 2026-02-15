@extends('layouts.app-stock')

@section('title', 'Modifier Employé')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="table-card">
            <div class="mb-4">
                <h5 class="fw-bold">
                    <i class="bi bi-pencil-square text-primary me-2"></i>Modifier : {{ $employe->nom_complet }}
                </h5>
            </div>

            <form action="{{ route('admin.employes.update', $employe) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Matricule <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-badge-tm"></i></span>
                            <input type="text" name="matricule" class="form-control @error('matricule') is-invalid @enderror" value="{{ old('matricule', $employe->matricule) }}" required>
                        </div>
                        @error('matricule')
                        <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Direction <span class="text-danger">*</span></label>
                        <select name="direction_id" class="form-select @error('direction_id') is-invalid @enderror" required>
                            @foreach($directions as $direction)
                            <option value="{{ $direction->id }}" {{ old('direction_id', $employe->direction_id) == $direction->id ? 'selected' : '' }}>
                                {{ $direction->nom_direction }}
                            </option>
                            @endforeach
                        </select>
                        @error('direction_id')
                        <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nom <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom', $employe->nom) }}" required>
                        </div>
                        @error('nom')
                        <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Prénom <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" name="prenom" class="form-control @error('prenom') is-invalid @enderror" value="{{ old('prenom', $employe->prenom) }}" required>
                        </div>
                        @error('prenom')
                        <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Poste</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
                            <input type="text" name="poste" class="form-control @error('poste') is-invalid @enderror" value="{{ old('poste', $employe->poste) }}">
                        </div>
                        @error('poste')
                        <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                        @enderror
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.employes.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle me-2"></i>Annuler
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-2"></i>Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection