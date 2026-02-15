@extends('layouts.app-stock')

@section('title', 'Détails Article')

@section('content')
<!-- En-tête -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">
            <i class="bi bi-box-seam text-primary me-2"></i>{{ $unite->designation }}
        </h5>
        <span class="badge bg-secondary">{{ $unite->code_unite }}</span>
        <span class="badge bg-info ms-2">{{ strtoupper($unite->unite_mesure) }}</span>
    </div>
    <div>
        <a href="{{ route('admin.unites.edit', $unite->id) }}" class="btn btn-primary">
            <i class="bi bi-pencil-square me-2"></i>Modifier
        </a>
        <a href="{{ route('admin.unites.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Retour
        </a>
    </div>
</div>

<!-- Informations générales -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="table-card text-center">
            <div class="mb-3">
                <i class="bi bi-box-seam display-4 text-primary"></i>
            </div>
            <h6 class="text-muted mb-1">Stock Actuel</h6>
            <h3 class="fw-bold {{ $unite->en_alerte ? 'text-danger' : 'text-success' }}">
                {{ number_format($unite->stock_actuel, 2) }}
            </h3>
            <small class="text-muted">{{ $unite->unite_mesure }}</small>

            @if($unite->en_alerte)
            <div class="alert alert-danger mt-3 mb-0">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Alerte Stock !</strong><br>
                Seuil : {{ number_format($unite->seuil_alerte, 2) }}
            </div>
            @endif
        </div>
    </div>

    <div class="col-md-3">
        <div class="table-card">
            <h6 class="text-muted mb-3">
                <i class="bi bi-box-arrow-in-down text-success me-2"></i>Entrées
            </h6>
            <h4 class="fw-bold text-success mb-1">{{ $unite->total_entrees }}</h4>
            <small class="text-muted">opérations</small>
        </div>
    </div>

    <div class="col-md-3">
        <div class="table-card">
            <h6 class="text-muted mb-3">
                <i class="bi bi-box-arrow-up text-danger me-2"></i>Sorties
            </h6>
            <h4 class="fw-bold text-danger mb-1">{{ $unite->total_sorties }}</h4>
            <small class="text-muted">opérations</small>
        </div>
    </div>

    <div class="col-md-3">
        <div class="table-card">
            <h6 class="text-muted mb-3">
                <i class="bi bi-cash-stack text-warning me-2"></i>Valeur Stock
            </h6>
            <h4 class="fw-bold text-warning mb-1">{{ number_format($unite->valeur_stock, 2) }} DT</h4>
            <small class="text-muted">Prix moyen : {{ number_format($unite->prix_moyen, 2) }} DT</small>
        </div>
    </div>
</div>

<!-- Informations détaillées -->
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="table-card">
            <h6 class="fw-bold mb-3">
                <i class="bi bi-info-circle text-primary me-2"></i>Informations
            </h6>
            <table class="table table-sm">
                <tr>
                    <th width="40%">Catégorie</th>
                    <td>
                        <span class="badge bg-info">
                            <i class="bi bi-tag me-1"></i>{{ $unite->categorie->libelle }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Magasin</th>
                    <td>{{ $unite->magasin->nom_magasin }}</td>
                </tr>
                <tr>
                    <th>Unité de mesure</th>
                    <td><span class="badge bg-secondary">{{ strtoupper($unite->unite_mesure) }}</span></td>
                </tr>
                <tr>
                    <th>Seuil d'alerte</th>
                    <td>
                        @if($unite->seuil_alerte > 0)
                        <strong>{{ number_format($unite->seuil_alerte, 2) }}</strong> {{ $unite->unite_mesure }}
                        @else
                        <span class="text-muted">Non configuré</span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="col-md-6">
        <div class="table-card">
            <h6 class="fw-bold mb-3">
                <i class="bi bi-clock-history text-primary me-2"></i>Dernières Entrées
            </h6>
            @forelse($unite->dernieres_entrees(5) as $entree)
            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                <div>
                    <small class="text-muted">{{ $entree->created_at->format('d/m/Y') }}</small><br>
                    <strong class="text-success">+{{ number_format($entree->quantite, 2) }}</strong>
                    <small class="text-muted">{{ $unite->unite_mesure }}</small>
                </div>
                <div class="text-end">
                    <small class="text-muted d-block">{{ $entree->fournisseur?->nom_fournisseur ?? '-' }}</small>
                    <span class="badge bg-secondary">{{ $entree->code_entree }}</span>
                </div>
            </div>
            @empty
            <p class="text-muted text-center mb-0">Aucune entrée</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Dernières sorties -->
<div class="table-card">
    <h6 class="fw-bold mb-3">
        <i class="bi bi-box-arrow-up text-danger me-2"></i>Dernières Sorties
    </h6>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Code</th>
                    <th>Quantité</th>
                    <th>Employé</th>
                    <th>Nature</th>
                    <th>Enregistré par</th>
                </tr>
            </thead>
            <tbody>
                @forelse($unite->dernieres_sorties(10) as $sortie)
                <tr>
                    <td>{{ $sortie->created_at->format('d/m/Y H:i') }}</td>
                    <td><span class="badge bg-secondary">{{ $sortie->code_sortie }}</span></td>
                    <td><strong class="text-danger">-{{ number_format($sortie->quantite, 2) }}</strong> {{ $unite->unite_mesure }}</td>
                    <td>{{ $sortie->employe?->nom_complet ?? '-' }}</td>
                    <td><span class="badge bg-info">{{ $sortie->nature_sortie }}</span></td>
                    <td>{{ $sortie->user->name }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">
                        Aucune sortie enregistrée
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection