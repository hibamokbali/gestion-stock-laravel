@extends('layouts.app-stock')

@section('title', 'Modifier Entrée')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="table-card">
            <div class="mb-4">
                <h5 class="fw-bold">
                    <i class="bi bi-pencil-square text-primary me-2"></i>Modifier l'Entrée
                </h5>
                <p class="text-muted mb-0">Code : <strong>{{ $entree->code_entree }}</strong></p>
            </div>

            <form action="{{ route(auth()->user()->isAdmin() ? 'admin.entrees.update' : 'user.entrees.update', $entree->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Article <span class="text-danger">*</span></label>
                        <select name="unite_id" class="form-select @error('unite_id') is-invalid @enderror" required>
                            <option value="">-- Sélectionnez un article --</option>
                            @foreach($unites as $unite)
                            <option value="{{ $unite->id }}" {{ old('unite_id', $entree->unite_id) == $unite->id ? 'selected' : '' }}>
                                {{ $unite->code_unite }} - {{ $unite->designation }} ({{ $unite->unite_mesure }})
                            </option>
                            @endforeach
                        </select>
                        @error('unite_id')
                        <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Fournisseur</label>
                        <select name="fournisseur_id" class="form-select @error('fournisseur_id') is-invalid @enderror">
                            <option value="">-- Sélectionnez un fournisseur --</option>
                            @foreach($fournisseurs as $fournisseur)
                            <option value="{{ $fournisseur->id }}" {{ old('fournisseur_id', $entree->fournisseur_id) == $fournisseur->id ? 'selected' : '' }}>
                                {{ $fournisseur->nom_fournisseur }}
                            </option>
                            @endforeach
                        </select>
                        @error('fournisseur_id')
                        <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Quantité <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-123"></i></span>
                            <input type="number" name="quantite" step="0.01" min="0.01" class="form-control @error('quantite') is-invalid @enderror" value="{{ old('quantite', $entree->quantite) }}" required>
                        </div>
                        @error('quantite')
                        <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Prix Unitaire (DT)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                            <input type="number" name="prix_unit" step="0.01" min="0" class="form-control @error('prix_unit') is-invalid @enderror" value="{{ old('prix_unit', $entree->prix_unit) }}">
                        </div>
                        @error('prix_unit')
                        <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Date Réception <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                            <input type="date" name="date_reception" class="form-control @error('date_reception') is-invalid @enderror" value="{{ old('date_reception', $entree->date_reception->format('Y-m-d')) }}" required>
                        </div>
                        @error('date_reception')
                        <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">N° Bon de Livraison</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-receipt"></i></span>
                            <input type="text" name="numero_bon" class="form-control @error('numero_bon') is-invalid @enderror" value="{{ old('numero_bon', $entree->numero_bon) }}">
                        </div>
                        @error('numero_bon')
                        <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">N° Facture</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-file-text"></i></span>
                            <input type="text" name="numero_facture" class="form-control @error('numero_facture') is-invalid @enderror" value="{{ old('numero_facture', $entree->numero_facture) }}">
                        </div>
                        @error('numero_facture')
                        <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                        @enderror
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route(auth()->user()->isAdmin() ? 'admin.entrees.index' : 'user.entrees.index') }}" class="btn btn-secondary">
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