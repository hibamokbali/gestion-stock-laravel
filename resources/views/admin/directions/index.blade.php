@extends('layouts.app-stock')

@section('title', 'Gestion des Directions')

@section('content')
<div class="table-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0">
            <i class="bi bi-building text-primary me-2"></i>Liste des Directions
        </h5>
        <a href="{{ route('admin.directions.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Nouvelle Direction
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Nom Direction</th>
                    <th>Statut</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($directions as $direction)
                <tr>
                    <td><span class="badge bg-secondary">{{ $direction->code_direction }}</span></td>
                    <td><strong>{{ $direction->nom_direction }}</strong></td>
                    <td>
                        <span class="badge bg-success">
                            <i class="bi bi-check-circle-fill me-1"></i>Actif
                        </span>
                    </td>
                    <td class="text-end">
                        <div class="btn-group">
                            <a href="{{ route('admin.directions.edit', $direction) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('admin.directions.destroy', $direction) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette direction ?');">
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
                    <td colspan="4" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                        <p class="mb-0">Aucune direction enregistrée</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $directions->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection