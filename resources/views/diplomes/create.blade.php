{{-- diplomes/create.blade.php --}}
@extends('layouts.app')
@section('title', 'Ajouter un diplôme')
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Ajouter un diplôme</h1>
        <a href="{{ route('diplomes.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Retour à la liste
        </a>
    </div>
    <div class="card">
    <div class="card-body">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('diplomes.store') }}" method="POST">
            @csrf
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            Informations du diplôme
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="libelle" class="form-label">Libellé <span class="text-danger">*</span></label>
                                <select class="form-select @error('libelle') is-invalid @enderror" id="libelle" name="libelle" required>
                                    <option value="">Sélectionner un type de diplôme</option>
                                    <option value="Baccaulérat" @selected(old('libelle') == 'Baccaulérat')>Baccalauréat</option>
                                    <option value="Licence" @selected(old('libelle') == 'Licence')>Licence</option>
                                    <option value="Licence Professionnelle" @selected(old('libelle') == 'Licence Professionnelle')>Licence Professionnelle</option>
                                    <option value="Master" @selected(old('libelle') == 'Master')>Master</option>
                                    <option value="Doctorant" @selected(old('libelle') == 'Doctorant')>Doctorat</option>
                                </select>
                                @error('libelle')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="abreviation" class="form-label">Abréviation</label>
                                <input type="text" class="form-control @error('abreviation') is-invalid @enderror" id="abreviation" name="abreviation" value="{{ old('abreviation') }}">
                                @error('abreviation')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="serie" class="form-label">Série</label>
                                <input type="text" class="form-control @error('serie') is-invalid @enderror" id="serie" name="serie" value="{{ old('serie') }}">
                                @error('serie')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="specialite" class="form-label">Spécialité</label>
                                <input type="text" class="form-control @error('specialite') is-invalid @enderror" id="specialite" name="specialite" value="{{ old('specialite') }}">
                                @error('specialite')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="option" class="form-label">Option</label>
                                <input type="text" class="form-control @error('option') is-invalid @enderror" id="option" name="option" value="{{ old('option') }}">
                                @error('option')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="statut" class="form-label">Statut <span class="text-danger">*</span></label>
                                <select class="form-select @error('statut') is-invalid @enderror" id="statut" name="statut" required>
                                    <option value="active" @selected(old('statut', 'active') == 'active')>Active</option>
                                    <option value="inactive" @selected(old('statut') == 'inactive')>Inactive</option>
                                </select>
                                @error('statut')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            Niveaux accessibles
                        </div>
                        <div class="card-body">
                            <p class="text-info">Sélectionnez les niveaux qui peuvent être accessibles avec ce diplôme</p>

                            @if($niveauxAccessibles->count() > 0)
                                <div class="row">
                                    @foreach($niveauxAccessibles as $niveau)
                                    <div class="col-md-6 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="niveaux[]" value="{{ $niveau->id }}" id="niveau{{ $niveau->id }}" @checked(in_array($niveau->id, old('niveaux', [])))>
                                            <label class="form-check-label" for="niveau{{ $niveau->id }}">
                                                {{ $niveau->libelle }} - {{ $niveau->filiere->libelle }} ({{ $niveau->filiere->departement->abreviation }})
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-warning mb-0">
                                    Aucun niveau accessible disponible. Veuillez d'abord créer des niveaux marqués comme accessibles.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="reset" class="btn btn-secondary me-2">Réinitialiser</button>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        // Liaison automatique entre libellé et abréviation
        $('#libelle').change(function() {
            let abreviation = '';
            switch($(this).val()) {
                case 'Baccaulérat': abreviation = 'BAC'; break;
                case 'Licence': abreviation = 'LIC'; break;
                case 'Licence Professionnelle': abreviation = 'LP'; break;
                case 'Master': abreviation = 'MST'; break;
                case 'Doctorant': abreviation = 'DOC'; break;
            }
            if(!$('#abreviation').val()) {
                $('#abreviation').val(abreviation);
            }
        });
    });
</script>
@endpush
