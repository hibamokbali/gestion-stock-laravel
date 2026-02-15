@extends('layouts.app-stock')

@section('title', 'Nouvelle Sortie')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="table-card">
            <div class="mb-4">
                <h5 class="fw-bold">
                    <i class="bi bi-box-arrow-up text-danger me-2"></i>Enregistrer une Sortie de Stock
                </h5>
                <p class="text-muted mb-0">Enregistrez une nouvelle sortie de marchandise.</p>
            </div>

            @if(session('error'))
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            </div>
            @endif

            <form action="{{ route(auth()->user()->isAdmin() ? 'admin.sorties.store' : 'user.sorties.store') }}" method="POST">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Article <span class="text-danger">*</span></label>
                        <select name="unite_id" class="form-select @error('unite_id') is-invalid @enderror" id="unite_select" required>
                            <option value="">-- Sélectionnez un article --</option>
                            @foreach($unites as $unite)
                            <option value="{{ $unite->id }}" data-stock="{{ $unite->stock_actuel }}" data-unite="{{ $unite->unite_mesure }}" {{ old('unite_id') == $unite->id ? 'selected' : '' }}>
                                {{ $unite->code_unite }} - {{ $unite->designation }} (Stock: {{ number_format($unite->stock_actuel, 2) }})
                            </option>
                            @endforeach
                        </select>
                        @error('unite_id')
                        <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                        @enderror
                        <div id="stock_info" class="mt-2" style="display: none;">
                            <small class="text-info">
                                <i class="bi bi-info-circle me-1"></i>Stock disponible : <strong id="stock_value">0</strong> <span id="unite_mesure"></span>
                            </small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Employé</label>
                        <select name="employe_id" class="form-select @error('employe_id') is-invalid @enderror">
                            <option value="">-- Sélectionnez un employé --</option>
                            @foreach($employes as $employe)
                            <option value="{{ $employe->id }}" {{ old('employe_id') == $employe->id ? 'selected' : '' }}>
                                {{ $employe->matricule }} - {{ $employe->nom_complet }}
                            </option>
                            @endforeach
                        </select>
                        @error('employe_id')
                        <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Quantité <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-123"></i></span>
                            <input type="number" name="quantite" step="0.01" min="0.01" class="form-control @error('quantite') is-invalid @enderror" value="{{ old('quantite') }}" placeholder="Ex: 10" id="quantite_input" required>
                        </div>
                        @error('quantite')
                        <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nature de Sortie <span class="text-danger">*</span></label>
                        <select name="nature_sortie" class="form-select @error('nature_sortie') is-invalid @enderror" required>
                            <option value="">-- Sélectionnez --</option>
                            <option value="Consommation interne" {{ old('nature_sortie') == 'Consommation interne' ? 'selected' : '' }}>Consommation interne</option>
                            <option value="Distribution service" {{ old('nature_sortie') == 'Distribution service' ? 'selected' : '' }}>Distribution service</option>
                            <option value="Prêt" {{ old('nature_sortie') == 'Prêt' ? 'selected' : '' }}>Prêt</option>
                            <option value="Casse" {{ old('nature_sortie') == 'Casse' ? 'selected' : '' }}>Casse</option>
                            <option value="Perte" {{ old('nature_sortie') == 'Perte' ? 'selected' : '' }}>Perte</option>
                            <option value="Autre" {{ old('nature_sortie') == 'Autre' ? 'selected' : '' }}>Autre</option>
                        </select>
                        @error('nature_sortie')
                        <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                        @enderror
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route(auth()->user()->isAdmin() ? 'admin.sorties.index' : 'user.sorties.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle me-2"></i>Annuler
                    </a>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-check-circle me-2"></i>Enregistrer la Sortie
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Afficher le stock disponible
    document.getElementById('unite_select').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const stock = selectedOption.getAttribute('data-stock');
        const unite = selectedOption.getAttribute('data-unite');

        if (stock) {
            document.getElementById('stock_value').textContent = parseFloat(stock).toFixed(2);
            document.getElementById('unite_mesure').textContent = unite;
            document.getElementById('stock_info').style.display = 'block';
        } else {
            document.getElementById('stock_info').style.display = 'none';
        }
    });
</script>
@endsection