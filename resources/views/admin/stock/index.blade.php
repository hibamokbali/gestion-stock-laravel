@extends('layouts.app-stock')

@section('title', 'État du Stock')

@section('content')
<!-- Filtres -->
<div class="table-card mb-4">
    <form method="GET" action="{{ route(auth()->user()->isAdmin() ? 'admin.stock.index' : 'user.stock.index') }}">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Rechercher</label>
                <input type="text" name="search" class="form-control" placeholder="Code ou désignation" value="{{ request('search') }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">Catégorie</label>
                <select name="categorie_id" class="form-select">
                    <option value="">Toutes</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('categorie_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->libelle }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Magasin</label>
                <select name="magasin_id" class="form-select">
                    <option value="">Tous</option>
                    @foreach($magasins as $mag)
                    <option value="{{ $mag->id }}" {{ request('magasin_id') == $mag->id ? 'selected' : '' }}>
                        {{ $mag->nom_magasin }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Filtrer</label>
                <select name="alerte" class="form-select">
                    <option value="">Tous les articles</option>
                    <option value="1" {{ request('alerte') == '1' ? 'selected' : '' }}>⚠️ Alertes uniquement</option>
                </select>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-funnel me-2"></i>Filtrer
                </button>
                <a href="{{ route(auth()->user()->isAdmin() ? 'admin.stock.index' : 'user.stock.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-2"></i>Réinitialiser
                </a>
            </div>
        </div>
    </form>
</div>

<!-- Tableau Stock -->
<div class="table-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0">
            <i class="bi bi-box-seam text-primary me-2"></i>État du Stock
        </h5>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Désignation</th>
                    <th>Catégorie</th>
                    <th>Magasin</th>
                    <th>Stock Actuel</th>
                    <th>Seuil</th>
                    <th>Statut</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($unites as $unite)
                <tr class="{{ $unite->stock_actuel <= 0 ? 'table-danger' : ($unite->en_alerte ? 'table-warning' : '') }}">
                    <td><span class="badge bg-secondary">{{ $unite->code_unite }}</span></td>
                    <td><strong>{{ $unite->designation }}</strong></td>
                    <td><span class="badge bg-info">{{ $unite->categorie->libelle }}</span></td>
                    <td>{{ $unite->magasin->nom_magasin }}</td>
                    <td>
                        <strong class="{{ $unite->stock_actuel <= 0 ? 'text-danger' : ($unite->en_alerte ? 'text-warning' : 'text-success') }} fs-5">
                            {{ number_format($unite->stock_actuel, 2) }}
                        </strong>
                        <small class="text-muted">{{ $unite->unite_mesure }}</small>
                    </td>
                    <td>
                        @if($unite->seuil_alerte > 0)
                        {{ number_format($unite->seuil_alerte, 2) }}
                        @else
                        <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        @if($unite->stock_actuel <= 0) <span class="badge bg-danger">
                            <i class="bi bi-x-circle-fill me-1"></i>RUPTURE
                            </span>
                            @elseif($unite->en_alerte)
                            <span class="badge bg-warning text-dark">
                                <i class="bi bi-exclamation-triangle-fill me-1"></i>ALERTE
                            </span>
                            @else
                            <span class="badge bg-success">
                                <i class="bi bi-check-circle-fill me-1"></i>OK
                            </span>
                            @endif
                    </td>
                    <td class="text-end">
                        @if(auth()->user()->isAdmin())
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#seuilModal{{ $unite->id }}" title="Configurer seuil">
                                <i class="bi bi-gear"></i>
                            </button>
                            <a href="{{ route('admin.unites.show', $unite->id) }}" class="btn btn-sm btn-outline-info" title="Voir détails">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>
                        @else
                        <span class="text-muted">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                        <p class="mb-0">Aucun article trouvé</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $unites->links('pagination::bootstrap-5') }}
    </div>
</div>

<!-- Légende -->
<div class="table-card mt-4">
    <h6 class="fw-bold mb-3">Légende</h6>
    <div class="d-flex gap-4 flex-wrap">
        <div>
            <span class="badge bg-success me-2">OK</span>
            <small>Stock au-dessus du seuil</small>
        </div>
        <div>
            <span class="badge bg-warning text-dark me-2">ALERTE</span>
            <small>Stock en dessous du seuil</small>
        </div>
        <div>
            <span class="badge bg-danger me-2">RUPTURE</span>
            <small>Stock épuisé (0)</small>
        </div>
    </div>
</div>


<!-- MODALS CONFIGURATION SEUILS (Admin Only) -->

@if(auth()->user()->isAdmin())
@foreach($unites as $unite)
<div class="modal fade" id="seuilModal{{ $unite->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-gear text-warning me-2"></i>
                    Configurer Seuil d'Alerte
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.unites.configure-seuil', $unite) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- Info article -->
                    <div class="alert alert-info mb-3">
                        <h6 class="mb-2"><strong>{{ $unite->designation }}</strong></h6>
                        <small class="text-muted">Code : {{ $unite->code_unite }}</small>
                    </div>

                    <!-- État actuel -->
                    <div class="row mb-3">
                        <div class="col-6">
                            <small class="text-muted d-block">Stock actuel</small>
                            <strong class="{{ $unite->en_alerte ? 'text-danger' : 'text-success' }} fs-5">
                                {{ number_format($unite->stock_actuel, 2) }}
                            </strong>
                            <small class="text-muted">{{ $unite->unite_mesure }}</small>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Seuil actuel</small>
                            <strong class="fs-5">
                                {{ $unite->seuil_alerte > 0 ? number_format($unite->seuil_alerte, 2) : '-' }}
                            </strong>
                            <small class="text-muted">{{ $unite->unite_mesure }}</small>
                        </div>
                    </div>

                    <!-- Formulaire -->
                    <div class="mb-3">
                        <label class="form-label">Nouveau Seuil d'Alerte <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-bell"></i></span>
                            {{-- ✅ CORRECTION ICI : name="valeur_alerte" → name="seuil" --}}
                            <input type="number" name="seuil" class="form-control" value="{{ $unite->seuil_alerte }}" step="0.01" min="0" placeholder="Ex: 10" required>
                            <span class="input-group-text">{{ $unite->unite_mesure }}</span>
                        </div>
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            Vous serez alerté si le stock descend à ou en dessous de cette valeur.
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i>Annuler
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-save me-2"></i>Enregistrer le Seuil
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endif

@endsection