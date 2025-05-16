{{-- filieres/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Créer une filière</div>

        <div class="card-body">
            <form method="POST" action="{{ route('filieres.store') }}">
                @csrf

                <!-- Informations de base de la filière -->
                <div class="form-group mb-3">
                    <label for="universite_id" class="form-label">Université <span class="text-danger">*</span></label>
                    <select class="form-select tomselect @error('universite_id') is-invalid @enderror"
                        id="universite_id" name="universite_id" required>
                        <option value="">Sélectionnez une université</option>
                        @foreach($universites as $universite)
                        <option value="{{ $universite->id }}" {{ old('universite_id')==$universite->id ?
                            'selected' : '' }}>
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
                    <select class="form-select @error('ufr_id') is-invalid @enderror" id="ufr_id" name="ufr_id"
                        required>
                        <option value="">Sélectionnez d'abord une université</option>
                    </select>
                    @error('ufr_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="departement_id" class="form-label">Département <span
                            class="text-danger">*</span></label>
                    <select class="form-select @error('departement_id') is-invalid @enderror" id="departement_id"
                        name="departement_id" required>
                        <option value="">Sélectionnez d'abord une UFR</option>
                    </select>
                    @error('departement_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="libelle">Libellé</label>
                    <input type="text" class="form-control @error('libelle') is-invalid @enderror" id="libelle"
                        name="libelle" value="{{ old('libelle') }}" required>
                    @error('libelle')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="abreviation">Abréviation</label>
                    <input type="text" class="form-control @error('abreviation') is-invalid @enderror" id="abreviation"
                        name="abreviation" value="{{ old('abreviation') }}">
                    @error('abreviation')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="statut" class="form-label">Statut <span class="text-danger">*</span></label>
                    <select class="form-select @error('statut') is-invalid @enderror" id="statut" name="statut"
                        required>
                        <option value="">Sélectionnez un statut</option>
                        <option value="active" selected>Actif</option>
                        <option value="inactive">Inactif</option>
                    </select>
                    @error('statut')
                    <div class="invalid-feedback">{{ $message }}</div>
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
                            @endphp

                            @foreach($niveauxOptions as $key => $niveau)
                            <div class="col-md-3 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input niveau-checkbox" type="checkbox"
                                                name="niveaux[{{ $key }}][active]" id="niveau_{{ $key }}" {{
                                                old("niveaux.$key.active") ? 'checked' : '' }}>
                                            <label class="form-check-label" for="niveau_{{ $key }}">
                                                {{ $niveau['libelle'] }} ({{ $niveau['abreviation'] }})
                                            </label>
                                            <input type="hidden" name="niveaux[{{ $key }}][libelle]"
                                                value="{{ $niveau['libelle'] }}">
                                            <input type="hidden" name="niveaux[{{ $key }}][abreviation]"
                                                value="{{ $niveau['abreviation'] }}">
                                        </div>

                                        <div class="niveau-options" id="options_{{ $key }}" style="{{ old("
                                            niveaux.$key.active") ? '' : 'display: none;' }}">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input accessible-checkbox" type="checkbox"
                                                    name="niveaux[{{ $key }}][accessible]" id="accessible_{{ $key }}" {{
                                                    old("niveaux.$key.accessible") ? 'checked' : '' }}>
                                                <label class="form-check-label" for="accessible_{{ $key }}">
                                                    Accessible
                                                </label>
                                            </div>

                                            <div class="diplomes-section" id="diplomes_{{ $key }}" style="{{ old("
                                                niveaux.$key.accessible") ? '' : 'display: none;' }}">
                                                <label>Diplômes possibles:</label>
                                                <div style="max-height: 150px; overflow-y: auto;">
                                                    @foreach($diplomes as $diplome)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="niveaux[{{ $key }}][diplomes][]"
                                                            value="{{ $diplome->id }}"
                                                            id="diplome_{{ $key }}_{{ $diplome->id }}" {{
                                                            (is_array(old("niveaux.$key.diplomes")) &&
                                                            in_array($diplome->id, old("niveaux.$key.diplomes"))) ?
                                                        'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="diplome_{{ $key }}_{{ $diplome->id }}">
                                                            {{ $diplome->libelle . ' - ' . $diplome->serie . ' - ' .
                                                            $diplome->option }}
                                                        </label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <div class="form-group mt-2">
                                                <label for="statut_{{ $key }}">Statut:</label>
                                                <select class="form-control form-control-sm"
                                                    name="niveaux[{{ $key }}][statut]" id="statut_{{ $key }}">
                                                    <option value="active" {{ old("niveaux.$key.statut", 'active'
                                                        )=='active' ? 'selected' : '' }}>Active</option>
                                                    <option value="inactive" {{ old("niveaux.$key.statut")=='inactive'
                                                        ? 'selected' : '' }}>Inactive</option>
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

                <button type="submit" class="btn btn-primary">Enregistrer</button>
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

        // Charger les UFRs lorsque l'université est sélectionnée
        $('#universite_id').change(function() {
            var universiteId = $(this).val();
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
                    }
                });
            } else {
                $('#ufr_id').empty();
                $('#ufr_id').append('<option value="">Sélectionnez d\'abord une université</option>');
            }
        });

        // Déclencher le changement si une université est déjà sélectionnée (cas de validation avec erreurs)
        if ($('#universite_id').val()) {
            $('#universite_id').trigger('change');

            // Sélectionner l'UFR précédemment choisie après le chargement des données
            var oldUfrId = "{{ old('ufr_id') }}";
            if (oldUfrId) {
                setTimeout(function() {
                    $('#ufr_id').val(oldUfrId);
                }, 500);
            }
        }

        // Charger les Départements lorsque l'université est sélectionnée
        $('#ufr_id').change(function() {
            var ufrId = $(this).val();
            if (ufrId) {
                $.ajax({
                    url: '/api/ufrs/' + ufrId + '/departements',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#departement_id').empty();
                        $('#departement_id').append('<option value="">Sélectionnez une UFR</option>');
                        $.each(data, function(key, value) {
                            $('#departement_id').append('<option value="' + value.id + '">' + value.libelle + ' (' + value.abreviation + ')</option>');
                        });
                    }
                });
            } else {
                $('#departement_id').empty();
                $('#departement_id').append('<option value="">Sélectionnez d\'abord un département</option>');
            }
        });

        // Déclencher le changement si une UFR est déjà sélectionnée (cas de validation avec erreurs)
        if ($('#ufr_id').val()) {
            $('#ufr_id').trigger('change');

            // Sélectionner le Département précédemment choisie après le chargement des données
            var oldDepartementId = "{{ old('departement_id') }}";
            if (oldDepartementId) {
                setTimeout(function() {
                    $('#departement_id').val(oldDepartementId);
                }, 500);
            }
        }
    });
</script>
@endsection
