@extends('layouts.app-stock')

@section('title', 'Mon Dashboard')

@section('content')

<!-- MES STATISTIQUES DU MOIS -->
<div class="row g-4 mb-4">
    <!-- Mes Entrées -->
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #00b09b 0%, #96c93d 100%); color: white;">
                <i class="bi bi-box-arrow-in-down"></i>
            </div>
            <div class="stat-card-title">Mes Entrées du Mois</div>
            <div class="stat-card-value text-success">{{ $stats['mes_entrees_mois'] }}</div>
            <small class="text-muted">{{ number_format($stats['quantite_entrees'], 0) }} unités</small>
        </div>
    </div>

    <!-- Mes Sorties -->
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #f85032 0%, #e73827 100%); color: white;">
                <i class="bi bi-box-arrow-up"></i>
            </div>
            <div class="stat-card-title">Mes Sorties du Mois</div>
            <div class="stat-card-value text-danger">{{ $stats['mes_sorties_mois'] }}</div>
            <small class="text-muted">{{ number_format($stats['quantite_sorties'], 0) }} unités</small>
        </div>
    </div>

    <!-- Articles Totaux -->
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <i class="bi bi-box-seam"></i>
            </div>
            <div class="stat-card-title">Articles en Stock</div>
            <div class="stat-card-value text-primary">{{ $stats['total_articles'] }}</div>
            <small class="text-muted">Articles actifs</small>
        </div>
    </div>

    <!-- Alertes Stock -->
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                <i class="bi bi-exclamation-triangle"></i>
            </div>
            <div class="stat-card-title">Alertes Stock</div>
            <div class="stat-card-value text-warning">{{ $stats['alertes_stock'] }}</div>
            <small class="text-muted">Articles en alerte</small>
        </div>
    </div>
</div>


<!-- ARTICLES EN ALERTE (VISIBLE PAR USER) -->

<div class="table-card mb-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0">
            <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>
            Articles en Alerte ({{ $stats['alertes_stock'] }})
        </h5>
        <a href="{{ route('user.stock.index') }}?alerte=1" class="btn btn-danger btn-sm">
            <i class="bi bi-eye me-2"></i>Voir tous
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Désignation</th>
                    <th>Catégorie</th>
                    <th>Stock Actuel</th>
                    <th>Seuil</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @forelse($articles_critiques as $article)
                <tr class="{{ $article->stock_actuel <= 0 ? 'table-danger' : 'table-warning' }}">
                    <td><span class="badge bg-secondary">{{ $article->code_unite }}</span></td>
                    <td><strong>{{ $article->designation }}</strong></td>
                    <td><span class="badge bg-info">{{ $article->categorie->libelle }}</span></td>
                    <td>
                        <strong class="{{ $article->stock_actuel <= 0 ? 'text-danger' : 'text-warning' }} fs-5">
                            {{ number_format($article->stock_actuel, 2) }}
                        </strong>
                        <small class="text-muted">{{ $article->unite_mesure }}</small>
                    </td>
                    <td>{{ number_format($article->seuil_alerte, 2) }}</td>
                    <td>
                        @if($article->stock_actuel <= 0) <span class="badge bg-danger">
                            <i class="bi bi-x-circle-fill me-1"></i>RUPTURE
                            </span>
                            @else
                            <span class="badge bg-warning text-dark">
                                <i class="bi bi-exclamation-triangle-fill me-1"></i>ALERTE
                            </span>
                            @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-success">
                        <i class="bi bi-check-circle-fill fs-1 d-block mb-3"></i>
                        <strong>Aucun article en alerte !</strong>
                        <p class="text-muted mb-0">Tous les articles ont un stock suffisant.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($articles_critiques->count() >= 5 && $stats['alertes_stock'] > 5)
    <div class="text-center mt-3">
        <a href="{{ route('user.stock.index') }}?alerte=1" class="btn btn-outline-danger">
            <i class="bi bi-arrow-right-circle me-2"></i>
            Voir les {{ $stats['alertes_stock'] }} articles en alerte
        </a>
    </div>
    @endif
</div>


<!-- ACCÈS RAPIDES -->

<div class="table-card mb-4">
    <h6 class="fw-bold mb-3">
        <i class="bi bi-lightning-charge text-warning me-2"></i>Accès Rapides
    </h6>
    <div class="row g-3">
        <div class="col-md-3">
            <a href="{{ route('user.entrees.create') }}" class="btn btn-success w-100">
                <i class="bi bi-plus-circle me-2"></i>Nouvelle Entrée
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('user.sorties.create') }}" class="btn btn-danger w-100">
                <i class="bi bi-dash-circle me-2"></i>Nouvelle Sortie
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('user.stock.index') }}" class="btn btn-primary w-100">
                <i class="bi bi-box-seam me-2"></i>Consulter Stock
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('user.stock.index') }}?alerte=1" class="btn btn-warning w-100">
                <i class="bi bi-exclamation-triangle me-2"></i>Voir Alertes
            </a>
        </div>
    </div>
</div>


<!-- MES DERNIÈRES ACTIVITÉS -->

<div class="row g-4">
    <!-- Mes Dernières Entrées -->
    <div class="col-md-6">
        <div class="table-card">
            <h6 class="fw-bold mb-3">
                <i class="bi bi-clock-history text-success me-2"></i>Mes Dernières Entrées
            </h6>
            @forelse($mes_dernieres_entrees as $entree)
            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                <div>
                    <strong class="text-success">+{{ number_format($entree->quantite, 2) }}</strong>
                    <small class="text-muted ms-1">{{ $entree->unite->designation }}</small>
                </div>
                <small class="text-muted">{{ $entree->created_at->diffForHumans() }}</small>
            </div>
            @empty
            <p class="text-muted text-center mb-0">Aucune entrée enregistrée</p>
            @endforelse
            <div class="text-center mt-3">
                <a href="{{ route('user.entrees.index') }}" class="btn btn-sm btn-outline-success">
                    Voir toutes mes entrées
                </a>
            </div>
        </div>
    </div>

    <!-- Mes Dernières Sorties -->
    <div class="col-md-6">
        <div class="table-card">
            <h6 class="fw-bold mb-3">
                <i class="bi bi-clock-history text-danger me-2"></i>Mes Dernières Sorties
            </h6>
            @forelse($mes_dernieres_sorties as $sortie)
            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                <div>
                    <strong class="text-danger">-{{ number_format($sortie->quantite, 2) }}</strong>
                    <small class="text-muted ms-1">{{ $sortie->unite->designation }}</small>
                </div>
                <small class="text-muted">{{ $sortie->created_at->diffForHumans() }}</small>
            </div>
            @empty
            <p class="text-muted text-center mb-0">Aucune sortie enregistrée</p>
            @endforelse
            <div class="text-center mt-3">
                <a href="{{ route('user.sorties.index') }}" class="btn btn-sm btn-outline-danger">
                    Voir toutes mes sorties
                </a>
            </div>
        </div>
    </div>
</div>

@endsection