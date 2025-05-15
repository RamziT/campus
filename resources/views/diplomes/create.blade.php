{{-- resources/views/diplomes/create.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Créer un diplôme') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('diplomes.store') }}">
                            @csrf

                            <div class="form-group mb-3">
                                <label for="libelle">{{ __('Libellé') }}</label>
                                <select class="form-control @error('libelle') is-invalid @enderror" id="libelle" name="libelle" required>
                                    <option value="" selected disabled>Sélectionnez un libellé</option>
                                    <option value="Baccaulérat" {{ old('libelle') == 'Baccaulérat' ? 'selected' : '' }}>Baccaulérat</option>
                                    <option value="Licence" {{ old('libelle') == 'Licence' ? 'selected' : '' }}>Licence</option>
                                    <option value="Licence Professionnelle" {{ old('libelle') == 'Licence Professionnelle' ? 'selected' : '' }}>Licence Professionnelle</option>
                                    <option value="Master" {{ old('libelle') == 'Master' ? 'selected' : '' }}>Master</option>
                                    <option value="Doctorant" {{ old('libelle') == 'Doctorant' ? 'selected' : '' }}>Doctorant</option>
                                </select>
                                @error('libelle')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="abreviation">{{ __('Abréviation') }}</label>
                                <input type="text" class="form-control @error('abreviation') is-invalid @enderror" id="abreviation" name="abreviation" value="{{ old('abreviation') }}">
                                @error('abreviation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="serie">{{ __('Série') }}</label>
                                <input type="text" class="form-control @error('serie') is-invalid @enderror" id="serie" name="serie" value="{{ old('serie') }}">
                                @error('serie')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="specialite">{{ __('Spécialité') }}</label>
                                <input type="text" class="form-control @error('specialite') is-invalid @enderror" id="specialite" name="specialite" value="{{ old('specialite') }}">
                                @error('specialite')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="option">{{ __('Option') }}</label>
                                <input type="text" class="form-control @error('option') is-invalid @enderror" id="option" name="option" value="{{ old('option') }}">
                                @error('option')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            @if(count($niveauxAccessibles) > 0)
                            <div class="form-group mb-3">
                                <label>{{ __('Niveaux accessibles avec ce diplôme') }}</label>
                                <div class="border p-3 rounded">
                                    @foreach($niveauxAccessibles as $niveau)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="niveaux[]" id="niveau{{ $niveau->id }}"
                                                value="{{ $niveau->id }}" {{ is_array(old('niveaux')) && in_array($niveau->id, old('niveaux')) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="niveau{{ $niveau->id }}">
                                                {{ $niveau->libelle }} ({{ $niveau->filiere->libelle }})
                                                @if($niveau->abreviation) - {{ $niveau->abreviation }} @endif
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('niveaux')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            @else
                            <div class="alert alert-info">
                                {{ __('Aucun niveau accessible n\'est défini dans le système. Pour associer ce diplôme à des niveaux, veuillez d\'abord créer des niveaux accessibles.') }}
                            </div>
                            @endif

                            <div class="form-group mb-3">
                                <label for="statut">{{ __('Statut') }}</label>
                                <select class="form-control @error('statut') is-invalid @enderror" id="statut" name="statut" required>
                                    <option value="active" {{ old('statut', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('statut') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('statut')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Créer') }}
                                </button>
                                <a href="{{ route('diplomes.index') }}" class="btn btn-secondary">
                                    {{ __('Annuler') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
