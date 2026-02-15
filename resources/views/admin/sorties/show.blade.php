@extends('layouts.app-stock')

@section('title', 'Détails Sortie')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <!-- En-tête -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-bold mb-1">
                    <i class="bi bi-box-arrow-up text-danger me-2"></i>Détails de la Sortie
                </h5>
                <span class="badge bg-danger me-2">{{ $sortie->code_sortie }}</span>
                <span class="badge bg-warning text-dark">{{ $sortie->numero_bon_decharge }}</span>
            </div>
            <div>
                <a href="{{ route(auth()->user()->isAdmin() ? 'admin.sorties.pdf' : 'user.sorties.pdf', $sortie->id) }}" 
                   class="btn btn-warning"
                   target="_blank">
                    <i class="bi bi-file-pdf me-2"></i>Fiche de Décharge
                </a>
                <a href="{{ route(auth()->user()->isAdmin() ? 'admin.sorties.edit' : 'user.sorties.edit', $sortie->id) }}" 
                   class="btn btn-primary">
                    <i class="bi bi-pencil-square me-2"></i>Modifier
                </a>
                <a href="{{ route(auth()->user()->isAdmin() ? 'admin.sorties.index' : 'user.sorties.index') }}" 
                   class="btn btn-secondary">
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
                        <h6 class="mb-0">{{ $sortie->unite->designation }}</h6>
                        <small class="text-muted">Code : {{ $sortie->unite->code_unite }}</small>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted d-block mb-1">Employé</small>
                        <h6 class="mb-0">{{ $sortie->employe?->nom_complet ?? 'Non spécifié' }}</h6>
                        @if($sortie->employe)
                            <small class="text-muted">Matricule : {{ $sortie->employe->matricule }}</small>
                        @endif
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="p-3 bg-danger bg-opacity-10 rounded">
                        <small class="text-muted d-block mb-1">Quantité</small>
                        <h4 class="mb-0 text-danger">{{ number_format($sortie->quantite, 2) }}</h4>
                        <small class="text-muted">{{ $sortie->unite->unite_mesure }}</small>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="p-3 bg-info bg-opacity-10 rounded">
                        <small class="text-muted d-block mb-1">Nature de Sortie</small>
                        <span class="badge {{ $sortie->nature_badge_class }} fs-6">{{ $sortie->nature_sortie }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Traçabilité -->
        <div class="table-card">
            <h6 class="fw-bold mb-3">
                <i class="bi bi-clock-history text-primary me-2"></i>Traçabilité
            </h6>
            <table class="table table-sm">
                <tr>
                    <th width="30%">Enregistré par</th>
                    <td>{{ $sortie->user->name }}</td>
                </tr>
                <tr>
                    <th>Date d'enregistrement</th>
                    <td>{{ $sortie->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @if($sortie->updated_at != $sortie->created_at)
                <tr>
                    <th>Dernière modification</th>
                    <td>{{ $sortie->updated_at->format('d/m/Y H:i') }}</td>
                </tr>
                @endif
            </table>
        </div>
    </div>
</div>
@endsection