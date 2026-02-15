@extends('layouts.app-stock')

@section('title', 'Gestion des Articles')

@section('content')
<div class="table-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0">
            <i class="bi bi-box-seam text-primary me-2"></i>Liste des Articles (Stock)
        </h5>
        <a href="{{ route('admin.unites.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Nouvel Article
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Désignation</th>
                    <th>Catégorie</th>
                    <th>Magasin</th>
                    <th>Unité</th>
                    <th>Stock</th>
                    <th>Statut</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($unites as $unite)
                <tr>
                    <td><span class="badge bg-secondary">{{ $unite->code_unite }}</span></td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary fw-bold d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                {{ strtoupper(substr($unite->designation, 0, 2)) }}
                            </div>
                            <strong>{{ $unite->designation }}</strong>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-info">
                            <i class="bi bi-tag me-1"></i>{{ $unite->categorie->libelle }}
                        </span>
                    </td>
                    <td>{{ $unite->magasin->nom_magasin }}</td>
                    <td><span class="badge bg-secondary">{{ strtoupper($unite->unite_mesure) }}</span></td>
                    <td>
                        <strong class="{{ $unite->en_alerte ? 'text-danger' : 'text-success' }}">
                            {{ number_format($unite->stock_actuel, 2) }}
                        </strong>
                    </td>
                    <td>
                        @if($unite->en_alerte)
                        <span class="badge bg-danger">
                            <i class="bi bi-exclamation-triangle-fill me-1"></i>Alerte
                        </span>
                        @else
                        <span class="badge bg-success">
                            <i class="bi bi-check-circle-fill me-1"></i>OK
                        </span>
                        @endif
                    </td>
                    <td class="text-end">
                        <div class="btn-group">
                            <a href="{{ route('admin.unites.show', $unite->id) }}" class="btn btn-sm btn-outline-info" data-bs-toggle="tooltip" title="Voir détails">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('admin.unites.edit', $unite->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('admin.unites.destroy', $unite->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cet article ?');">
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
                    <td colspan="8" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                        <p class="mb-0">Aucun article enregistré</p>
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
@endsection