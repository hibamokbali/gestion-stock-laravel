@extends('layouts.app-stock')

@section('title', 'Dashboard Administrateur')

@section('content')

<!-- ════════════════════════════════════════════════════ -->
<!-- CARTES STATISTIQUES STOCK (Focus Principal) -->
<!-- ════════════════════════════════════════════════════ -->
<div class="row g-4 mb-4">
    <!-- Total Articles -->
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <i class="bi bi-box-seam"></i>
            </div>
            <div class="stat-card-title">Total Articles</div>
            <div class="stat-card-value text-primary">{{ $stats['total_articles'] }}</div>
            <small class="text-muted">Articles actifs</small>
        </div>
    </div>

    <!-- Stock OK -->
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #00b09b 0%, #96c93d 100%); color: white;">
                <i class="bi bi-check-circle"></i>
            </div>
            <div class="stat-card-title">Stock OK</div>
            <div class="stat-card-value text-success">{{ $stats['articles_ok'] }}</div>
            <small class="text-muted">Au-dessus du seuil</small>
        </div>
    </div>

    <!-- Alertes Stock -->
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                <i class="bi bi-exclamation-triangle"></i>
            </div>
            <div class="stat-card-title">Alertes Stock</div>
            <div class="stat-card-value text-warning">{{ $stats['articles_alerte'] }}</div>
            <small class="text-muted">En dessous du seuil</small>
        </div>
    </div>

    <!-- Ruptures -->
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #f85032 0%, #e73827 100%); color: white;">
                <i class="bi bi-x-circle"></i>
            </div>
            <div class="stat-card-title">Ruptures</div>
            <div class="stat-card-value text-danger">{{ $stats['articles_rupture'] }}</div>
            <small class="text-muted">Stock épuisé</small>
        </div>
    </div>
</div>


<!-- MOUVEMENTS DU MOIS -->

<div class="row g-4 mb-4">
    <!-- Entrées -->
    <div class="col-md-6">
        <div class="table-card">
            <h6 class="fw-bold mb-3">
                <i class="bi bi-box-arrow-in-down text-success me-2"></i>Entrées du Mois
            </h6>
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="fw-bold text-success mb-0">{{ $stats['entrees_mois'] }}</h3>
                    <small class="text-muted">opérations</small>
                </div>
                <div class="text-end">
                    <h4 class="fw-bold text-success mb-0">{{ number_format($stats['quantite_entrees_mois'], 0) }}</h4>
                    <small class="text-muted">unités reçues</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Sorties -->
    <div class="col-md-6">
        <div class="table-card">
            <h6 class="fw-bold mb-3">
                <i class="bi bi-box-arrow-up text-danger me-2"></i>Sorties du Mois
            </h6>
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="fw-bold text-danger mb-0">{{ $stats['sorties_mois'] }}</h3>
                    <small class="text-muted">opérations</small>
                </div>
                <div class="text-end">
                    <h4 class="fw-bold text-danger mb-0">{{ number_format($stats['quantite_sorties_mois'], 0) }}</h4>
                    <small class="text-muted">unités sorties</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ════════════════════════════════════════════════════ -->
<!-- ARTICLES EN ALERTE (CRITIQUES) -->
<!-- ════════════════════════════════════════════════════ -->
<div class="table-card mb-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0">
            <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>
            Articles en Alerte ({{ $stats['articles_alerte'] }})
        </h5>
        <a href="{{ route('admin.stock.index') }}?alerte=1" class="btn btn-danger btn-sm">
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
                    <th>Écart</th>
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
                        <span class="badge {{ $article->stock_actuel <= 0 ? 'bg-danger' : 'bg-warning' }}">
                            {{ number_format($article->stock_actuel - $article->seuil_alerte, 2) }}
                        </span>
                    </td>
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
                    <td colspan="7" class="text-center py-5 text-success">
                        <i class="bi bi-check-circle-fill fs-1 d-block mb-3"></i>
                        <strong>Aucun article en alerte !</strong>
                        <p class="text-muted mb-0">Tous les articles ont un stock suffisant.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($articles_critiques->count() >= 10 && $stats['articles_alerte'] > 10)
    <div class="text-center mt-3">
        <a href="{{ route('admin.stock.index') }}?alerte=1" class="btn btn-outline-danger">
            <i class="bi bi-arrow-right-circle me-2"></i>
            Voir les {{ $stats['articles_alerte'] }} articles en alerte
        </a>
    </div>
    @endif
</div>

<!-- ════════════════════════════════════════════════════ -->
<!-- TOP 5 ARTICLES LES PLUS CONSOMMÉS -->
<!-- ════════════════════════════════════════════════════ -->
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="table-card">
            <h6 class="fw-bold mb-3">
                <i class="bi bi-graph-up text-primary me-2"></i>Top 5 Articles Les Plus Consommés
            </h6>
            @forelse($top_consommes as $index => $item)
            <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary fw-bold d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                        {{ $index + 1 }}
                    </div>
                    <div>
                        <strong>{{ $item->unite->designation }}</strong><br>
                        <small class="text-muted">{{ $item->unite->unite_mesure }}</small>
                    </div>
                </div>
                <div class="text-end">
                    <h5 class="mb-0 text-primary">{{ number_format($item->total, 0) }}</h5>
                    <small class="text-muted">unités</small>
                </div>
            </div>
            @empty
            <p class="text-muted text-center mb-0">Aucune sortie ce mois</p>
            @endforelse
        </div>
    </div>

    <!-- Infos Secondaires -->
    <div class="col-md-6">
        <div class="table-card">
            <h6 class="fw-bold mb-3">
                <i class="bi bi-info-circle text-primary me-2"></i>Informations Générales
            </h6>
            <div class="row g-3">
                <div class="col-6">
                    <div class="p-3 bg-light rounded">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-building fs-3 text-info me-3"></i>
                            <div>
                                <h4 class="mb-0">{{ $stats['total_directions'] }}</h4>
                                <small class="text-muted">Directions</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="p-3 bg-light rounded">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-person-badge fs-3 text-success me-3"></i>
                            <div>
                                <h4 class="mb-0">{{ $stats['total_employes'] }}</h4>
                                <small class="text-muted">Employés</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- DERNIÈRES ACTIVITÉS -->

<div class="row g-4">
    <!-- Dernières Entrées -->
    <div class="col-md-6">
        <div class="table-card">
            <h6 class="fw-bold mb-3">
                <i class="bi bi-clock-history text-success me-2"></i>Dernières Entrées
            </h6>
            @forelse($dernieres_entrees as $entree)
            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                <div>
                    <strong class="text-success">+{{ number_format($entree->quantite, 2) }}</strong>
                    <small class="text-muted ms-1">{{ $entree->unite->designation }}</small><br>
                    <small class="text-muted">Par {{ $entree->user->name }}</small>
                </div>
                <small class="text-muted">{{ $entree->created_at->diffForHumans() }}</small>
            </div>
            @empty
            <p class="text-muted text-center mb-0">Aucune entrée récente</p>
            @endforelse
        </div>
    </div>

    <!-- Dernières Sorties -->
    <div class="col-md-6">
        <div class="table-card">
            <h6 class="fw-bold mb-3">
                <i class="bi bi-clock-history text-danger me-2"></i>Dernières Sorties
            </h6>
            @forelse($dernieres_sorties as $sortie)
            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                <div>
                    <strong class="text-danger">-{{ number_format($sortie->quantite, 2) }}</strong>
                    <small class="text-muted ms-1">{{ $sortie->unite->designation }}</small><br>
                    <small class="text-muted">Par {{ $sortie->user->name }}</small>
                </div>
                <small class="text-muted">{{ $sortie->created_at->diffForHumans() }}</small>
            </div>
            @empty
            <p class="text-muted text-center mb-0">Aucune sortie récente</p>
            @endforelse
        </div>
    </div>
</div>

@endsection