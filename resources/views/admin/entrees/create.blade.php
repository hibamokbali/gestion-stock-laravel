@extends('layouts.app-stock')

@section('title', 'Nouvelle Entrée')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="table-card">
            <div class="mb-4">
                <h5 class="fw-bold">
                    <i class="bi bi-box-arrow-in-down text-success me-2"></i>Enregistrer une Entrée de Stock
                </h5>
                <p class="text-muted mb-0">Enregistrez une nouvelle réception de marchandise.</p>
            </div>

            <form action="{{ route(auth()->user()->isAdmin() ? 'admin.entrees.store' : 'user.entrees.store') }}" method="POST">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Article <span class="text-danger">*</span></label>
                        <select name="unite_id" class="form-select @error('unite_id') is-invalid @enderror" required>
                            <option value="">-- Sélectionnez un article --</option>
                            @foreach($unites as $unite)
                            <option value="{{ $unite->id }}" {{ old('unite_id') == $unite->id ? 'selected' : '' }}>
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
                            <option value="{{ $fournisseur->id }}" {{ old('fournisseur_id') == $fournisseur->id ? 'selected' : '' }}>
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
                            <input type="number" name="quantite" step="0.01" min="0.01" class="form-control @error('quantite') is-invalid @enderror" value="{{ old('quantite') }}" placeholder="Ex: 100" required>
                        </div>
                        @error('quantite')
                        <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Prix Unitaire (DT)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                            <input type="number" name="prix_unit" step="0.01" min="0" class="form-control @error('prix_unit') is-invalid @enderror" value="{{ old('prix_unit') }}" placeholder="Ex: 25.50">
                        </div>
                        @error('prix_unit')
                        <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Date Réception <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                            <input type="date" name="date_reception" class="form-control @error('date_reception') is-invalid @enderror" value="{{ old('date_reception', date('Y-m-d')) }}" required>
                        </div>
                        @error('date_reception')
                        <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">N° Bon de Livraison</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-receipt"></i></span>
                            <input type="text" name="numero_bon" class="form-control @error('numero_bon') is-invalid @enderror" value="{{ old('numero_bon') }}" placeholder="Ex: BL-2025-001">
                        </div>
                        @error('numero_bon')
                        <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">N° Facture</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-file-text"></i></span>
                            <input type="text" name="numero_facture" class="form-control @error('numero_facture') is-invalid @enderror" value="{{ old('numero_facture') }}" placeholder="Ex: FAC-2025-001">
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
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-2"></i>Enregistrer l'Entrée
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection