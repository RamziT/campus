{{-- resources/views/niveaux/edit.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Modifier un niveau') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('niveaux.update', $niveau->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="form-group mb-3">
                                <label for="libelle">{{ __('Libellé') }}</label>
                                <select class="form-control @error('libelle') is-invalid @enderror" id="libelle" name="libelle" required>
                                    <option value="" disabled>Sélectionnez un libellé</option>
                                    <option value="Licence 1" {{ old('libelle', $niveau->libelle) == 'Licence 1' ? 'selected' : '' }}>Licence 1</option>
                                    <option value="Licence 2" {{ old('libelle', $niveau->libelle) == 'Licence 2' ? 'selected' : '' }}>Licence 2</option>
                                    <option value="Licence 3" {{ old('libelle', $niveau->libelle) == 'Licence 3' ? 'selected' : '' }}>Licence 3</option>
                                    <option value="Master 1" {{ old('libelle', $niveau->libelle) == 'Master 1' ? 'selected' : '' }}>Master 1</option>
                                    <option value="Master 2" {{ old('libelle', $niveau->libelle) == 'Master 2' ? 'selected' : '' }}>Master 2</option>
                                    <option value="Doctorat 1" {{ old('libelle', $niveau->libelle) == 'Doctorat 1' ? 'selected' : '' }}>Doctorat 1</option>
                                    <option value="Doctorat 2" {{ old('libelle', $niveau->libelle) == 'Doctorat 2' ? 'selected' : '' }}>Doctorat 2</option>
                                    <option value="Doctorat 3" {{ old('libelle', $niveau->libelle) == 'Doctorat 3' ? 'selected' : '' }}>Doctorat 3</option>
                                </select>
                                @error('libelle')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="abreviation">{{ __('Abréviation') }}</label>
                                <select class="form-control @error('abreviation') is-invalid @enderror" id="abreviation" name="abreviation">
                                    <option value="" disabled>Sélectionnez une abréviation</option>
                                    <option value="L1" {{ old('abreviation', $niveau->abreviation) == 'L1' ? 'selected' : '' }}>L1</option>
                                    <option value="L2" {{ old('abreviation', $niveau->abreviation) == 'L2' ? 'selected' : '' }}>L2</option>
                                    <option value="L3" {{ old('abreviation', $niveau->abreviation) == 'L3' ? 'selected' : '' }}>L3</option>
                                    <option value="M1" {{ old('abreviation', $niveau->abreviation) == 'M1' ? 'selected' : '' }}>M1</option>
                                    <option value="M2" {{ old('abreviation', $niveau->abreviation) == 'M2' ? 'selected' : '' }}>M2</option>
                                    <option value="D1" {{ old('abreviation', $niveau->abreviation) == 'D1' ? 'selected' : '' }}>D1</option>
                                    <option value="D2" {{ old('abreviation', $niveau->abreviation) == 'D2' ? 'selected' : '' }}>D2</option>
                                    <option value="D3" {{ old('abreviation', $niveau->abreviation) == 'D3' ? 'selected' : '' }}>D3</option>
                                </select>
                                @error('abreviation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="filiere_id">{{ __('Filière') }}</label>
                                <select class="form-control @error('filiere_id') is-invalid @enderror" id="filiere_id" name="filiere_id" required>
                                    <option value="" disabled>Sélectionnez une filière</option>
                                    @foreach($filieres as $filiere)
                                        <option value="{{ $filiere->id }}" {{ old('filiere_id', $niveau->filiere_id) == $filiere->id ? 'selected' : '' }}>
                                            {{ $filiere->libelle }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('filiere_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="accessible" id="accessible" value="1"
                                        {{ old('accessible', $niveau->accessible) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="accessible">
                                        {{ __('Ce niveau est accessible (nécessite des diplômes pour y accéder)') }}
                                    </label>
                                </div>
                            </div>

                            <div class="form-group mb-3 diplomes-section" style="{{ old('accessible', $niveau->accessible) ? '' : 'display:none;' }}">
                                <label>{{ __('Diplômes permettant d\'accéder à ce niveau') }}</label>
                                <div class="border p-3 rounded">
                                    @php
                                        $selectedDiplomes = old('diplomes', $niveau->diplomes->pluck('id')->toArray());
                                    @endphp
                                    @foreach($diplomes as $diplome)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="diplomes[]" id="diplome{{ $diplome->id }}"
                                                value="{{ $diplome->id }}" {{ in_array($diplome->id, $selectedDiplomes) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="diplome{{ $diplome->id }}">
                                                {{ $diplome->libelle }}
                                                @if($diplome->serie) - {{ $diplome->serie }} @endif
                                                @if($diplome->option) ({{ $diplome->option }}) @endif
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('diplomes')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="statut">{{ __('Statut') }}</label>
                                <select class="form-control @error('statut') is-invalid @enderror" id="statut" name="statut" required>
                                    <option value="active" {{ old('statut', $niveau->statut) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('statut', $niveau->statut) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('statut')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Mettre à jour') }}
                                </button>
                                <a href="{{ route('niveaux.index') }}" class="btn btn-secondary">
                                    {{ __('Annuler') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const accessibleCheckbox = document.getElementById('accessible');
            const diplomesSection = document.querySelector('.diplomes-section');

            accessibleCheckbox.addEventListener('change', function() {
                diplomesSection.style.display = this.checked ? 'block' : 'none';
            });
        });
    </script>
    @endpush
@endsection
