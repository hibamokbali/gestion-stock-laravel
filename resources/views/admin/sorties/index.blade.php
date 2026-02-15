@extends('layouts.app-stock')

@section('title', 'Gestion des Sorties')

@section('content')
<div class="table-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0">
            <i class="bi bi-box-arrow-up text-danger me-2"></i>
            Liste des Sorties de Stock
        </h5>
        <a href="{{ route(auth()->user()->isAdmin() ? 'admin.sorties.create' : 'user.sorties.create') }}" class="btn btn-danger">
            <i class="bi bi-plus-circle me-2"></i>Nouvelle Sortie
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Code</th>
                    <th>N° Bon Décharge</th>
                    <th>Article</th>
                    <th>Employé</th>
                    <th>Quantité</th>
                    <th>Nature</th>
                    <th>Enregistré par</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sorties as $sortie)
                <tr>
                    <td>{{ $sortie->created_at->format('d/m/Y') }}</td>
                    <td><span class="badge bg-danger">{{ $sortie->code_sortie }}</span></td>
                    <td><span class="badge bg-warning text-dark">{{ $sortie->numero_bon_decharge }}</span></td>
                    <td>
                        <strong>{{ $sortie->unite->designation }}</strong><br>
                        <small class="text-muted">{{ $sortie->unite->code_unite }}</small>
                    </td>
                    <td>{{ $sortie->employe?->nom_complet ?? '-' }}</td>
                    <td>
                        <strong class="text-danger">{{ number_format($sortie->quantite, 2) }}</strong>
                        <small class="text-muted">{{ $sortie->unite->unite_mesure }}</small>
                    </td>
                    <td><span class="badge {{ $sortie->nature_badge_class }}">{{ $sortie->nature_sortie }}</span></td>
                    <td>
                        <small>{{ $sortie->user->name }}</small><br>
                        <small class="text-muted">{{ $sortie->created_at->format('d/m/Y H:i') }}</small>
                    </td>
                    <td class="text-end">
                        <div class="btn-group">
                            <a href="{{ route(auth()->user()->isAdmin() ? 'admin.sorties.show' : 'user.sorties.show', $sortie->id) }}" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route(auth()->user()->isAdmin() ? 'admin.sorties.pdf' : 'user.sorties.pdf', $sortie->id) }}" class="btn btn-sm btn-outline-secondary" target="_blank">
                                <i class="bi bi-file-pdf"></i>
                            </a>
                            <a href="{{ route(auth()->user()->isAdmin() ? 'admin.sorties.edit' : 'user.sorties.edit', $sortie->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route(auth()->user()->isAdmin() ? 'admin.sorties.destroy' : 'user.sorties.destroy', $sortie->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette sortie ?');">
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
                        <p class="mb-0">Aucune sortie enregistrée</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $sorties->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection