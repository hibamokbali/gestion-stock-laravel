@extends('layouts.app-stock')

@section('title', 'Détails Entrée')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <!-- En-tête -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-bold mb-1">
                    <i class="bi bi-box-arrow-in-down text-success me-2"></i>Détails de l'Entrée
                </h5>
                <span class="badge bg-success">{{ $entree->code_entree }}</span>
            </div>
            <div>
                <a href="{{ route(auth()->user()->isAdmin() ? 'admin.entrees.edit' : 'user.entrees.edit', $entree->id) }}" class="btn btn-primary">
                    <i class="bi bi-pencil-square me-2"></i>Modifier
                </a>
                <a href="{{ route(auth()->user()->isAdmin() ? 'admin.entrees.index' : 'user.entrees.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Retour
                </a>
            </div>
        </div>

        <!-- Informations principales -->
        <div class="table-card mb-4">
            <h6 class="fw-bold mb-3">
                <i class="bi bi-info-circle text-primary me-2"></i>Informations Générales
            </h6>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted d-block mb-1">Article</small>
                        <h6 class="mb-0">{{ $entree->unite->designation }}</h6>
                        <small class="text-muted">Code : {{ $entree->unite->code_unite }}</small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted d-block mb-1">Fournisseur</small>
                        <h6 class="mb-0">{{ $entree->fournisseur?->nom_fournisseur ?? 'Non spécifié' }}</h6>
                        @if($entree->fournisseur)
                        <small class="text-muted">{{ $entree->fournisseur->code_fournisseur }}</small>
                        @endif
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-3 bg-success bg-opacity-10 rounded">
                        <small class="text-muted d-block mb-1">Quantité</small>
                        <h4 class="mb-0 text-success">{{ number_format($entree->quantite, 2) }}</h4>
                        <small class="text-muted">{{ $entree->unite->unite_mesure }}</small>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-3 bg-info bg-opacity-10 rounded">
                        <small class="text-muted d-block mb-1">Prix Unitaire</small>
                        @if($entree->prix_unit)
                        <h4 class="mb-0 text-info">{{ number_format($entree->prix_unit, 2) }} DT</h4>
                        @else
                        <h4 class="mb-0 text-muted">-</h4>
                        @endif
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-3 bg-warning bg-opacity-10 rounded">
                        <small class="text-muted d-block mb-1">Montant Total</small>
                        @if($entree->montant_total > 0)
                        <h4 class="mb-0 text-warning">{{ number_format($entree->montant_total, 2) }} DT</h4>
                        @else
                        <h4 class="mb-0 text-muted">-</h4>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Documents -->
        <div class="table-card mb-4">
            <h6 class="fw-bold mb-3">
                <i class="bi bi-file-text text-primary me-2"></i>Documents
            </h6>
            <table class="table table-sm">
                <tr>
                    <th width="30%">Date de Réception</th>
                    <td>{{ $entree->date_reception->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <th>N° Bon de Livraison</th>
                    <td>{{ $entree->numero_bon ?? '-' }}</td>
                </tr>
                <tr>
                    <th>N° Facture</th>
                    <td>{{ $entree->numero_facture ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <!-- Traçabilité -->
        <div class="table-card">
            <h6 class="fw-bold mb-3">
                <i class="bi bi-clock-history text-primary me-2"></i>Traçabilité
            </h6>
            <table class="table table-sm">
                <tr>
                    <th width="30%">Enregistré par</th>
                    <td>{{ $entree->user->name }}</td>
                </tr>
                <tr>
                    <th>Date d'enregistrement</th>
                    <td>{{ $entree->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @if($entree->updated_at != $entree->created_at)
                <tr>
                    <th>Dernière modification</th>
                    <td>{{ $entree->updated_at->format('d/m/Y H:i') }}</td>
                </tr>
                @endif
            </table>
        </div>
    </div>
</div>
@endsection