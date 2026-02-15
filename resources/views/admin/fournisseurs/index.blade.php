@extends('layouts.app-stock')

@section('title', 'Gestion des Fournisseurs')

@section('content')
<div class="table-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0">
            <i class="bi bi-truck text-primary me-2"></i>Liste des Fournisseurs
        </h5>
        <a href="{{ route('admin.fournisseurs.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Nouveau Fournisseur
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Nom Fournisseur</th>
                    <th>Téléphone</th>
                    <th>Email</th>
                    <th>Adresse</th>
                    <th>Statut</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($fournisseurs as $fournisseur)
                <tr>
                    <td><span class="badge bg-secondary">{{ $fournisseur->code_fournisseur }}</span></td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-warning bg-opacity-10 text-warning fw-bold d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                {{ strtoupper(substr($fournisseur->nom_fournisseur, 0, 2)) }}
                            </div>
                            <strong>{{ $fournisseur->nom_fournisseur }}</strong>
                        </div>
                    </td>
                    <td>{{ $fournisseur->telephone ?? '-' }}</td>
                    <td>{{ $fournisseur->email ?? '-' }}</td>
                    <td>{{ $fournisseur->adresse ? Str::limit($fournisseur->adresse, 30) : '-' }}</td>
                    <td>
                        <span class="badge bg-success">
                            <i class="bi bi-check-circle-fill me-1"></i>Actif
                        </span>
                    </td>
                    <td class="text-end">
                        <div class="btn-group">
                            <a href="{{ route('admin.fournisseurs.edit', $fournisseur->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('admin.fournisseurs.destroy', $fournisseur->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce fournisseur ?');">
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
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                        <p class="mb-0">Aucun fournisseur enregistré</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $fournisseurs->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection