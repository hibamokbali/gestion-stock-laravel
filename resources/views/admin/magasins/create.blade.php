@extends('layouts.app-stock')

@section('title', 'Créer un Magasin')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="table-card">
            <div class="mb-4">
                <h5 class="fw-bold">
                    <i class="bi bi-shop text-primary me-2"></i>Nouveau Magasin
                </h5>
            </div>

            <form action="{{ route('admin.magasins.store') }}" method="POST">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Code Magasin <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-hash"></i></span>
                            <input type="text" name="code_magasin" class="form-control @error('code_magasin') is-invalid @enderror" value="{{ old('code_magasin') }}" placeholder="Ex: MAG-001" required>
                        </div>
                        @error('code_magasin')
                        <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nom Magasin <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-shop"></i></span>
                            <input type="text" name="nom_magasin" class="form-control @error('nom_magasin') is-invalid @enderror" value="{{ old('nom_magasin') }}" placeholder="Ex: Magasin Central" required>
                        </div>
                        @error('nom_magasin')
                        <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Direction <span class="text-danger">*</span></label>
                        <select name="direction_id" class="form-select @error('direction_id') is-invalid @enderror" required>
                            <option value="">-- Sélectionnez une direction --</option>
                            @foreach($directions as $direction)
                            <option value="{{ $direction->id }}" {{ old('direction_id') == $direction->id ? 'selected' : '' }}>
                                {{ $direction->nom_direction }}
                            </option>
                            @endforeach
                        </select>
                        @error('direction_id')
                        <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Emplacement</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                            <input type="text" name="emplacement" class="form-control @error('emplacement') is-invalid @enderror" value="{{ old('emplacement') }}" placeholder="Ex: Bâtiment A, Étage 2">
                        </div>
                        @error('emplacement')
                        <div class="text-danger mt-2"><small>{{ $message }}</small></div>
                        @enderror
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.magasins.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle me-2"></i>Annuler
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-2"></i>Créer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection