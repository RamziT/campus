{{-- filieres/edit.blade.php --}}
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
                    <label for="universite_id" class="form-label">Université <span class="text-danger">*</span></label>
                        <select class="form-select tomselect @error('universite_id') is-invalid @enderror" id="universite_id" name="universite_id" required>
                            <option value="">Sélectionnez une université</option>
                            @foreach($universites as $universite)
                                <option value="{{ $universite->id }}" {{ (old('universite_id', $filiere->departement->ufr->universite_id) == $universite->id) ? 'selected' : '' }}>
                                    {{ $universite->libelle }} ({{ $universite->abreviation }})
                                </option>
                            @endforeach
                        </select>
                        @error('universite_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="ufr_id" class="form-label">UFR <span class="text-danger">*</span></label>
                        <select class="form-select @error('ufr_id') is-invalid @enderror" id="ufr_id" name="ufr_id" required>
                            <option value="">Sélectionnez d'abord une université</option>
                        </select>
                        @error('ufr_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="departement_id" class="form-label">Département <span class="text-danger">*</span></label>
                        <select class="form-select @error('departement_id') is-invalid @enderror" id="departement_id" name="departement_id" required>
                            <option value="">Sélectionnez d'abord une UFR</option>
                        </select>
                        @error('departement_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                </div>

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

        // Fonction pour charger les UFRs d'une université
        function loadUfrs(universiteId, selectedUfrId = null) {
            if (universiteId) {
                $.ajax({
                    url: '/api/universites/' + universiteId + '/ufrs',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#ufr_id').empty();
                        $('#ufr_id').append('<option value="">Sélectionnez une UFR</option>');
                        $.each(data, function(key, value) {
                            $('#ufr_id').append('<option value="' + value.id + '">' + value.libelle + ' (' + value.abreviation + ')</option>');
                        });

                        // Sélectionner l'UFR si fourni
                        if (selectedUfrId) {
                            $('#ufr_id').val(selectedUfrId);
                        }
                    }
                });
            } else {
                $('#ufr_id').empty();
                $('#ufr_id').append('<option value="">Sélectionnez d\'abord une université</option>');
            }
        }

        // Charger les UFRs lorsque l'université est sélectionnée
        $('#universite_id').change(function() {
            loadUfrs($(this).val());
        });

        // Chargement initial des UFRs pour l'université actuelle
        var universiteId = $('#universite_id').val();
        var ufrId = "{{ old('ufr_id', $filiere->departement->ufr_id) }}";

        if (universiteId) {
            loadUfrs(universiteId, ufrId);
        }

        // Fonction pour charger les Départements d'une UFR
        function loadDepartements(ufrId, selectedDepartementId = null) {
            if (ufrId) {
                $.ajax({
                    url: '/api/ufrs/' + ufrId + '/departements',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#departement_id').empty();
                        $('#departement_id').append('<option value="">Sélectionnez un département</option>');
                        $.each(data, function(key, value) {
                            $('#departement_id').append('<option value="' + value.id + '">' + value.libelle + ' (' + value.abreviation + ')</option>');
                        });

                        // Sélectionner le Departement si fourni
                        if (selectedDepartementId) {
                            $('#departement_id').val(selectedDepartementId);
                        }
                    }
                });
            } else {
                $('#departement_id').empty();
                $('#departement_id').append('<option value="">Sélectionnez d\'abord une UFR</option>');
            }
        }

        // Charger les Départements lorsque l'UFR' est sélectionnée
        $('#ufr_id').change(function() {
            loadDepartements($(this).val());
        });

        // Chargement initial des Départements pour l'UFR actuelle
        var ufrId = $('#ufr_id').val();
        var departementId = "{{ old('departement_id', $filiere->departement_id) }}";

        if (universiteId) {
            loadDepartements(ufrId, departementId);
        }
    });
</script>
@endsection
