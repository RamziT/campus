@extends('layouts.app')

@section('title', 'Modifier une université')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Modifier l'université</h1>
        <div>
            <a href="{{ route('universites.index') }}" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left me-1"></i> Retour à la liste
            </a>
            <a href="{{ route('universites.show', $universite) }}" class="btn btn-info">
                <i class="fas fa-eye me-1"></i> Voir les détails
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('universites.update', $universite) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="libelle" class="form-label">Libellé <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('libelle') is-invalid @enderror" id="libelle" name="libelle" value="{{ old('libelle', $universite->libelle) }}" required>
                            @error('libelle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="abreviation" class="form-label">Abréviation</label>
                            <input type="text" class="form-control @error('abreviation') is-invalid @enderror" id="abreviation" name="abreviation" value="{{ old('abreviation', $universite->abreviation) }}">
                            @error('abreviation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="ville" class="form-label">Ville</label>
                            <input type="text" class="form-control @error('ville') is-invalid @enderror" id="ville" name="ville" value="{{ old('ville', $universite->ville) }}">
                            @error('ville')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="telephone" class="form-label">Téléphone</label>
                            <input type="text" class="form-control @error('telephone') is-invalid @enderror" id="telephone" name="telephone" value="{{ old('telephone', $universite->telephone) }}">
                            @error('telephone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $universite->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="site_web" class="form-label">Site web</label>
                            <input type="url" class="form-control @error('site_web') is-invalid @enderror" id="site_web" name="site_web" value="{{ old('site_web', $universite->site_web) }}">
                            @error('site_web')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="adresse" class="form-label">Adresse</label>
                            <textarea class="form-control @error('adresse') is-invalid @enderror" id="adresse" name="adresse" rows="3">{{ old('adresse', $universite->adresse) }}</textarea>
                            @error('adresse')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="statut" class="form-label">Statut <span class="text-danger">*</span></label>
                            <div class="d-flex">
                                <div class="form-check me-3">
                                    <input class="form-check-input" type="radio" name="statut" id="statut_active" value="active" {{ old('statut', $universite->statut) == 'active' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="statut_active">
                                        Active
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="statut" id="statut_inactive" value="inactive" {{ old('statut', $universite->statut) == 'inactive' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="statut_inactive">
                                        Inactive
                                    </label>
                                </div>
                            </div>
                            @error('statut')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save me-1"></i> Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
