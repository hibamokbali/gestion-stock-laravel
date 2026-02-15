@extends('layouts.app-stock')

@section('title', 'Modifier Fournisseur')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="table-card">
            <div class="mb-4">
                <h5 class="fw-bold">
                    <i class="bi bi-pencil-square text-primary me-2"></i>Modifier : {{ $fournisseur->nom_fournisseur }}
                </h5>
            </div>

            <form action="{{ route('admin.fournisseurs.update', $fournisseur->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Code Fournisseur <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-hash"></i></span>
                            <input type="text" name="code_fournisseur" class="form-control @error('code_fournisseur') is-invalid @enderror" value="{{ old('code_fournisseur', $fournisseur->code_fournisseur) }}" required>
                        </div>
                        @error('code_fournisseur')
                        <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nom Fournisseur <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-building"></i></span>
                            <input type="text" name="nom_fournisseur" class="form-control @error('nom_fournisseur') is-invalid @enderror" value="{{ old('nom_fournisseur', $fournisseur->nom_fournisseur) }}" required>
                        </div>
                        @error('nom_fournisseur')
                        <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Téléphone</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                            <input type="text" name="telephone" class="form-control @error('telephone') is-invalid @enderror" value="{{ old('telephone', $fournisseur->telephone) }}">
                        </div>
                        @error('telephone')
                        <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $fournisseur->email) }}">
                        </div>
                        @error('email')
                        <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Adresse</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                            <textarea name="adresse" rows="3" class="form-control @error('adresse') is-invalid @enderror">{{ old('adresse', $fournisseur->adresse) }}</textarea>
                        </div>
                        @error('adresse')
                        <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                        @enderror
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.fournisseurs.index') }}" class="btn btn-secondary">
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