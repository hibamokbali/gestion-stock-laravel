@extends('layouts.app-stock')

@section('title', 'Modifier Article')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="table-card">
            <div class="mb-4">
                <h5 class="fw-bold">
                    <i class="bi bi-pencil-square text-primary me-2"></i>Modifier : {{ $unite->designation }}
                </h5>
                <p class="text-muted mb-0">Code article : <strong>{{ $unite->code_unite }}</strong></p>
            </div>

            <form action="{{ route('admin.unites.update', $unite->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Code Article <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-upc-scan"></i></span>
                            <input type="text" name="code_unite" class="form-control @error('code_unite') is-invalid @enderror" value="{{ old('code_unite', $unite->code_unite) }}" required>
                        </div>
                        @error('code_unite')
                        <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Désignation <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-box"></i></span>
                            <input type="text" name="designation" class="form-control @error('designation') is-invalid @enderror" value="{{ old('designation', $unite->designation) }}" required>
                        </div>
                        @error('designation')
                        <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Catégorie <span class="text-danger">*</span></label>
                        <select name="categorie_id" class="form-select @error('categorie_id') is-invalid @enderror" required>
                            @foreach($categories as $categorie)
                            <option value="{{ $categorie->id }}" {{ old('categorie_id', $unite->categorie_id) == $categorie->id ? 'selected' : '' }}>
                                {{ $categorie->libelle }}
                            </option>
                            @endforeach
                        </select>
                        @error('categorie_id')
                        <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Magasin <span class="text-danger">*</span></label>
                        <select name="magasin_id" class="form-select @error('magasin_id') is-invalid @enderror" required>
                            @foreach($magasins as $magasin)
                            <option value="{{ $magasin->id }}" {{ old('magasin_id', $unite->magasin_id) == $magasin->id ? 'selected' : '' }}>
                                {{ $magasin->nom_magasin }}
                            </option>
                            @endforeach
                        </select>
                        @error('magasin_id')
                        <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Unité de Mesure <span class="text-danger">*</span></label>
                        <select name="unite_mesure" class="form-select @error('unite_mesure') is-invalid @enderror" required>
                            <option value="pièce" {{ old('unite_mesure', $unite->unite_mesure) == 'pièce' ? 'selected' : '' }}>Pièce</option>
                            <option value="boîte" {{ old('unite_mesure', $unite->unite_mesure) == 'boîte' ? 'selected' : '' }}>Boîte</option>
                            <option value="paquet" {{ old('unite_mesure', $unite->unite_mesure) == 'paquet' ? 'selected' : '' }}>Paquet</option>
                            <option value="rame" {{ old('unite_mesure', $unite->unite_mesure) == 'rame' ? 'selected' : '' }}>Rame</option>
                            <option value="kg" {{ old('unite_mesure', $unite->unite_mesure) == 'kg' ? 'selected' : '' }}>Kilogramme (kg)</option>
                            <option value="g" {{ old('unite_mesure', $unite->unite_mesure) == 'g' ? 'selected' : '' }}>Gramme (g)</option>
                            <option value="litre" {{ old('unite_mesure', $unite->unite_mesure) == 'litre' ? 'selected' : '' }}>Litre</option>
                            <option value="ml" {{ old('unite_mesure', $unite->unite_mesure) == 'ml' ? 'selected' : '' }}>Millilitre (ml)</option>
                            <option value="mètre" {{ old('unite_mesure', $unite->unite_mesure) == 'mètre' ? 'selected' : '' }}>Mètre (m)</option>
                            <option value="cm" {{ old('unite_mesure', $unite->unite_mesure) == 'cm' ? 'selected' : '' }}>Centimètre (cm)</option>
                            <option value="lot" {{ old('unite_mesure', $unite->unite_mesure) == 'lot' ? 'selected' : '' }}>Lot</option>
                            <option value="rouleau" {{ old('unite_mesure', $unite->unite_mesure) == 'rouleau' ? 'selected' : '' }}>Rouleau</option>
                            <option value="carton" {{ old('unite_mesure', $unite->unite_mesure) == 'carton' ? 'selected' : '' }}>Carton</option>
                            <option value="sachet" {{ old('unite_mesure', $unite->unite_mesure) == 'sachet' ? 'selected' : '' }}>Sachet</option>
                            <option value="flacon" {{ old('unite_mesure', $unite->unite_mesure) == 'flacon' ? 'selected' : '' }}>Flacon</option>
                            <option value="tube" {{ old('unite_mesure', $unite->unite_mesure) == 'tube' ? 'selected' : '' }}>Tube</option>
                        </select>
                        @error('unite_mesure')
                        <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                        @enderror
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.unites.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle me-2"></i>Annuler
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-2"></i>Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection