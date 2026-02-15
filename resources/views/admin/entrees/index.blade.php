@extends('layouts.app-stock')

@section('title', 'Gestion des Entrées')

@section('content')
<div class="table-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0">
            <i class="bi bi-box-arrow-in-down text-success me-2"></i>
            Liste des Entrées de Stock
        </h5>
        <a href="{{ route(auth()->user()->isAdmin() ? 'admin.entrees.create' : 'user.entrees.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle me-2"></i>Nouvelle Entrée
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Code</th>
                    <th>Article</th>
                    <th>Fournisseur</th>
                    <th>Quantité</th>
                    <th>Prix Unit.</th>
                    <th>Total</th>
                    <th>Enregistré par</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($entrees as $entree)
                <tr>
                    <td>{{ $entree->date_reception->format('d/m/Y') }}</td>
                    <td><span class="badge bg-success">{{ $entree->code_entree }}</span></td>
                    <td>
                        <strong>{{ $entree->unite->designation }}</strong><br>
                        <small class="text-muted">{{ $entree->unite->code_unite }}</small>
                    </td>
                    <td>{{ $entree->fournisseur?->nom_fournisseur ?? '-' }}</td>
                    <td>
                        <strong class="text-success">{{ number_format($entree->quantite, 2) }}</strong>
                        <small class="text-muted">{{ $entree->unite->unite_mesure }}</small>
                    </td>
                    <td>
                        @if($entree->prix_unit)
                        {{ number_format($entree->prix_unit, 2) }} DT
                        @else
                        <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        @if($entree->montant_total > 0)
                        <strong>{{ number_format($entree->montant_total, 2) }} DT</strong>
                        @else
                        <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        <small>{{ $entree->user->name }}</small><br>
                        <small class="text-muted">{{ $entree->created_at->format('d/m/Y H:i') }}</small>
                    </td>
                    <td class="text-end">
                        <div class="btn-group">
                            <a href="{{ route(auth()->user()->isAdmin() ? 'admin.entrees.show' : 'user.entrees.show', $entree->id) }}" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route(auth()->user()->isAdmin() ? 'admin.entrees.edit' : 'user.entrees.edit', $entree->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route(auth()->user()->isAdmin() ? 'admin.entrees.destroy' : 'user.entrees.destroy', $entree->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette entrée ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                        <p class="mb-0">Aucune entrée enregistrée</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $entrees->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection