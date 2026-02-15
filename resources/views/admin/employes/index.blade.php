@extends('layouts.app-stock')

@section('title', 'Gestion des Employés')

@section('content')
<div class="table-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0">
            <i class="bi bi-person-badge-fill text-primary me-2"></i>Liste des Employés
        </h5>
        <a href="{{ route('admin.employes.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Nouvel Employé
        </a>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Matricule</th>
                    <th>Nom Complet</th>
                    <th>Direction</th>
                    <th>Poste</th>
                    <th>Statut</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employes as $employe)
                <tr>
                    <td><span class="badge bg-secondary">{{ $employe->matricule }}</span></td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-success bg-opacity-10 text-success fw-bold d-flex align-items-center justify-content-center me-3" 
                                 style="width: 40px; height: 40px;">
                                {{ strtoupper(substr($employe->nom, 0, 1)) }}{{ strtoupper(substr($employe->prenom, 0, 1)) }}
                            </div>
                            <strong>{{ $employe->nom_complet }}</strong>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-info">
                            <i class="bi bi-building me-1"></i>{{ $employe->direction->nom_direction }}
                        </span>
                    </td>
                    <td>{{ $employe->poste ?? '-' }}</td>
                    <td>
                        <span class="badge bg-success">
                            <i class="bi bi-check-circle-fill me-1"></i>Actif
                        </span>
                    </td>
                    <td class="text-end">
                        <div class="btn-group">
                            <a href="{{ route('admin.employes.edit', $employe) }}" 
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('admin.employes.destroy', $employe) }}" 
                                  method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirm('Supprimer cet employé ?');">
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
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                        <p class="mb-0">Aucun employé enregistré</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $employes->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection