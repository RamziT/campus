@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Modifier une filière</div>

        <div class="card-body">
            <form method="POST" action="{{ route('filieres.update', $filiere->id) }}">
                @csrf
                @method('PUT')

                <!-- Informations de base de la filière -->
                <div class="form-group mb-3">

                    <label for="libelle">Libellé</label>
                    <input type="text" class="form-control @error('libelle') is-invalid @enderror" id="libelle" name="libelle" value="{{ old('libelle', $filiere->libelle) }}" required>
                    @error('libelle')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="abreviation">Abréviation</label>
                    <input type="text" class="form-control @error('abreviation') is-invalid @enderror" id="abreviation" name="abreviation" value="{{ old('abreviation', $filiere->abreviation) }}">
                    @error('abreviation')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="departement_id">Département</label>
                    <select class="form-control @error('departement_id') is-invalid @enderror" id="departement_id" name="departement_id" required>
                        <option value="">Sélectionner un département</option>
                        @foreach($departements as $departement)
                            <option value="{{ $departement->id }}" {{ old('departement_id', $filiere->departement_id) == $departement->id ? 'selected' : '' }}>
                                {{ $departement->libelle }}
                            </option>
                        @endforeach
                    </select>
                    @error('departement_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="statut">Statut</label>
                    <select class="form-control @error('statut') is-invalid @enderror" id="statut" name="statut" required>
                        <option value="active" {{ old('statut', $filiere->statut) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('statut', $filiere->statut) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('statut')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Section pour les niveaux -->
                <h4 class="mt-4 mb-3">Niveaux</h4>
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            @php
                                $niveauxOptions = [
                                    'L1' => ['libelle' => 'Licence 1', 'abreviation' => 'L1'],
                                    'L2' => ['libelle' => 'Licence 2', 'abreviation' => 'L2'],
                                    'L3' => ['libelle' => 'Licence 3', 'abreviation' => 'L3'],
                                    'M1' => ['libelle' => 'Master 1', 'abreviation' => 'M1'],
                                    'M2' => ['libelle' => 'Master 2', 'abreviation' => 'M2'],
                                    'D1' => ['libelle' => 'Doctorat 1', 'abreviation' => 'D1'],
                                    'D2' => ['libelle' => 'Doctorat 2', 'abreviation' => 'D2'],
                                    'D3' => ['libelle' => 'Doctorat 3', 'abreviation' => 'D3'],
                                ];

                                // Récupérer les niveaux existants
                                $existingNiveaux = $filiere->niveaux ? $filiere->niveaux->keyBy('abreviation') : collect();
                            @endphp

                            @foreach($niveauxOptions as $key => $niveauOption)
                                @php
                                    $existingNiveau = $existingNiveaux->get($niveauOption['abreviation']);
                                    $isActive = old("niveaux.$key.active", $existingNiveau ? true : false);
                                    $isAccessible = old("niveaux.$key.accessible", $existingNiveau ? $existingNiveau->accessible : false);
                                    $niveauStatut = old("niveaux.$key.statut", $existingNiveau ? $existingNiveau->statut : 'active');

                                    // Récupérer les diplômes associés au niveau s'ils existent
                                    $niveauDiplomes = $existingNiveau && $existingNiveau->diplomes ? $existingNiveau->diplomes->pluck('id')->toArray() : [];
                                @endphp

                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input niveau-checkbox" type="checkbox" name="niveaux[{{ $key }}][active]" id="niveau_{{ $key }}" {{ $isActive ? 'checked' : '' }}>
                                                <label class="form-check-label" for="niveau_{{ $key }}">
                                                    {{ $niveauOption['libelle'] }} ({{ $niveauOption['abreviation'] }})
                                                </label>
                                                <input type="hidden" name="niveaux[{{ $key }}][libelle]" value="{{ $niveauOption['libelle'] }}">
                                                <input type="hidden" name="niveaux[{{ $key }}][abreviation]" value="{{ $niveauOption['abreviation'] }}">
                                                @if($existingNiveau)
                                                    <input type="hidden" name="niveaux[{{ $key }}][id]" value="{{ $existingNiveau->id }}">
                                                @endif
                                            </div>

                                            <div class="niveau-options" id="options_{{ $key }}" style="{{ $isActive ? '' : 'display: none;' }}">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input accessible-checkbox" type="checkbox" name="niveaux[{{ $key }}][accessible]" id="accessible_{{ $key }}" {{ $isAccessible ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="accessible_{{ $key }}">
                                                        Accessible
                                                    </label>
                                                </div>

                                                <div class="diplomes-section" id="diplomes_{{ $key }}" style="{{ $isAccessible ? '' : 'display: none;' }}">
                                                    <label>Diplômes requis:</label>
                                                    <div style="max-height: 150px; overflow-y: auto;">
                                                        @foreach($diplomes as $diplome)
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="niveaux[{{ $key }}][diplomes][]" value="{{ $diplome->id }}" id="diplome_{{ $key }}_{{ $diplome->id }}"
                                                                    {{ (is_array(old("niveaux.$key.diplomes")) && in_array($diplome->id, old("niveaux.$key.diplomes"))) ||
                                                                       (in_array($diplome->id, $niveauDiplomes)) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="diplome_{{ $key }}_{{ $diplome->id }}">
                                                                    {{ $diplome->libelle }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="form-group mt-2">
                                                    <label for="statut_{{ $key }}">Statut:</label>
                                                    <select class="form-control form-control-sm" name="niveaux[{{ $key }}][statut]" id="statut_{{ $key }}">
                                                        <option value="active" {{ $niveauStatut == 'active' ? 'selected' : '' }}>Active</option>
                                                        <option value="inactive" {{ $niveauStatut == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                <a href="{{ route('filieres.index') }}" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gestion des niveaux
        const niveauCheckboxes = document.querySelectorAll('.niveau-checkbox');
        niveauCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const key = this.id.replace('niveau_', '');
                const optionsDiv = document.getElementById('options_' + key);

                if (this.checked) {
                    optionsDiv.style.display = 'block';
                } else {
                    optionsDiv.style.display = 'none';
                }
            });
        });

        // Gestion de l'accessibilité
        const accessibleCheckboxes = document.querySelectorAll('.accessible-checkbox');
        accessibleCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const key = this.id.replace('accessible_', '');
                const diplomesDiv = document.getElementById('diplomes_' + key);

                if (this.checked) {
                    diplomesDiv.style.display = 'block';
                } else {
                    diplomesDiv.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection
