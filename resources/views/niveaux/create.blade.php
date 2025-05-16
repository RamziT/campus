{{-- niveaux/create.blade.php --}}
@extends('layouts.app')
@section('title', 'Ajouter un niveau')
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Ajouter un niveau</h1>
        <a href="{{ route('niveaux.index') }}" class="btn btn-secondary">
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

            <form action="{{ route('niveaux.store') }}" method="POST">
                @csrf
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                Structure académique
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="universite_id" class="form-label">Université <span class="text-danger">*</span></label>
                                    <select class="form-select @error('universite_id') is-invalid @enderror" id="universite_id" required>
                                        <option value="">Sélectionner une université</option>
                                        <!-- Options will be loaded dynamically -->
                                    </select>
                                    @error('universite_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="ufr_id" class="form-label">UFR <span class="text-danger">*</span></label>
                                    <select class="form-select @error('ufr_id') is-invalid @enderror" id="ufr_id" disabled>
                                        <option value="">Sélectionner d'abord une université</option>
                                    </select>
                                    @error('ufr_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="departement_id" class="form-label">Département <span class="text-danger">*</span></label>
                                    <select class="form-select @error('departement_id') is-invalid @enderror" id="departement_id" disabled>
                                        <option value="">Sélectionner d'abord une UFR</option>
                                    </select>
                                    @error('departement_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="filiere_id" class="form-label">Filière <span class="text-danger">*</span></label>
                                    <select class="form-select @error('filiere_id') is-invalid @enderror" id="filiere_id" name="filiere_id" required disabled>
                                        <option value="">Sélectionner d'abord un département</option>
                                    </select>
                                    @error('filiere_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-info text-white">
                                Informations du niveau
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="libelle" class="form-label">Libellé <span class="text-danger">*</span></label>
                                    <select class="form-select @error('libelle') is-invalid @enderror" id="libelle" name="libelle" required>
                                        <option value="">Sélectionner un niveau</option>
                                        <option value="Licence 1" @selected(old('libelle') == 'Licence 1')>Licence 1</option>
                                        <option value="Licence 2" @selected(old('libelle') == 'Licence 2')>Licence 2</option>
                                        <option value="Licence 3" @selected(old('libelle') == 'Licence 3')>Licence 3</option>
                                        <option value="Master 1" @selected(old('libelle') == 'Master 1')>Master 1</option>
                                        <option value="Master 2" @selected(old('libelle') == 'Master 2')>Master 2</option>
                                        <option value="Doctorat 1" @selected(old('libelle') == 'Doctorat 1')>Doctorat 1</option>
                                        <option value="Doctorat 2" @selected(old('libelle') == 'Doctorat 2')>Doctorat 2</option>
                                        <option value="Doctorat 3" @selected(old('libelle') == 'Doctorat 3')>Doctorat 3</option>
                                    </select>
                                    @error('libelle')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="abreviation" class="form-label">Abréviation</label>
                                    <select class="form-select @error('abreviation') is-invalid @enderror" id="abreviation" name="abreviation">
                                        <option value="">Sélectionner une abréviation</option>
                                        <option value="L1" @selected(old('abreviation') == 'L1')>L1</option>
                                        <option value="L2" @selected(old('abreviation') == 'L2')>L2</option>
                                        <option value="L3" @selected(old('abreviation') == 'L3')>L3</option>
                                        <option value="M1" @selected(old('abreviation') == 'M1')>M1</option>
                                        <option value="M2" @selected(old('abreviation') == 'M2')>M2</option>
                                        <option value="D1" @selected(old('abreviation') == 'D1')>D1</option>
                                        <option value="D2" @selected(old('abreviation') == 'D2')>D2</option>
                                        <option value="D3" @selected(old('abreviation') == 'D3')>D3</option>
                                    </select>
                                    @error('abreviation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="accessible" name="accessible" value="1" @checked(old('accessible'))>
                                    <label class="form-check-label" for="accessible">Niveau accessible aux inscriptions</label>
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
                </div>

                <div class="card mb-4" id="diplomes-section" style="display: none;">
                    <div class="card-header bg-success text-white">
                        Diplômes requis
                    </div>
                    <div class="card-body">
                        <p class="text-info">Sélectionnez les diplômes requis pour accéder à ce niveau</p>

                        <div class="row">
                            @foreach($diplomes as $diplome)
                            <div class="col-md-4 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="diplomes[]" value="{{ $diplome->id }}" id="diplome{{ $diplome->id }}" @checked(in_array($diplome->id, old('diplomes', [])))>
                                    <label class="form-check-label" for="diplome{{ $diplome->id }}">
                                        {{ $diplome->libelle }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
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
        // Gestion de l'affichage de la section des diplômes
        $('#accessible').change(function() {
            if ($(this).is(':checked')) {
                $('#diplomes-section').show();
            } else {
                $('#diplomes-section').hide();
            }
        });

        // Vérifier l'état initial de la case à cocher
        if ($('#accessible').is(':checked')) {
            $('#diplomes-section').show();
        }

        // Liaison automatique entre libellé et abréviation
        $('#libelle').change(function() {
            let abreviation = '';
            switch($(this).val()) {
                case 'Licence 1': abreviation = 'L1'; break;
                case 'Licence 2': abreviation = 'L2'; break;
                case 'Licence 3': abreviation = 'L3'; break;
                case 'Master 1': abreviation = 'M1'; break;
                case 'Master 2': abreviation = 'M2'; break;
                case 'Doctorat 1': abreviation = 'D1'; break;
                case 'Doctorat 2': abreviation = 'D2'; break;
                case 'Doctorat 3': abreviation = 'D3'; break;
            }
            $('#abreviation').val(abreviation);
        });

        // Charger la liste des universités
        $.ajax({
            url: '/api/universites',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                let options = '<option value="">Sélectionner une université</option>';
                $.each(data, function(index, universite) {
                    options += `<option value="${universite.id}">${universite.libelle}</option>`;
                });
                $('#universite_id').html(options);
            },
            error: function(xhr, status, error) {
                console.error('Erreur lors du chargement des universités:', error);
            }
        });

        // Charger les UFRs quand une université est sélectionnée
        $('#universite_id').change(function() {
            const universiteId = $(this).val();
            if (universiteId) {
                $.ajax({
                    url: `/api/universites/${universiteId}/ufrs`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        let options = '<option value="">Sélectionner une UFR</option>';
                        $.each(data, function(index, ufr) {
                            options += `<option value="${ufr.id}">${ufr.libelle}</option>`;
                        });
                        $('#ufr_id').html(options).prop('disabled', false);
                        $('#departement_id').html('<option value="">Sélectionner d\'abord une UFR</option>').prop('disabled', true);
                        $('#filiere_id').html('<option value="">Sélectionner d\'abord un département</option>').prop('disabled', true);
                    },
                    error: function(xhr, status, error) {
                        console.error('Erreur lors du chargement des UFRs:', error);
                    }
                });
            } else {
                $('#ufr_id').html('<option value="">Sélectionner d\'abord une université</option>').prop('disabled', true);
                $('#departement_id').html('<option value="">Sélectionner d\'abord une UFR</option>').prop('disabled', true);
                $('#filiere_id').html('<option value="">Sélectionner d\'abord un département</option>').prop('disabled', true);
            }
        });

        // Charger les départements quand une UFR est sélectionnée
        $('#ufr_id').change(function() {
            const ufrId = $(this).val();
            if (ufrId) {
                $.ajax({
                    url: `/api/ufrs/${ufrId}/departements`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        let options = '<option value="">Sélectionner un département</option>';
                        $.each(data, function(index, departement) {
                            options += `<option value="${departement.id}">${departement.libelle}</option>`;
                        });
                        $('#departement_id').html(options).prop('disabled', false);
                        $('#filiere_id').html('<option value="">Sélectionner d\'abord un département</option>').prop('disabled', true);
                    },
                    error: function(xhr, status, error) {
                        console.error('Erreur lors du chargement des départements:', error);
                    }
                });
            } else {
                $('#departement_id').html('<option value="">Sélectionner d\'abord une UFR</option>').prop('disabled', true);
                $('#filiere_id').html('<option value="">Sélectionner d\'abord un département</option>').prop('disabled', true);
            }
        });

        // Charger les filières quand un département est sélectionné
        $('#departement_id').change(function() {
            const departementId = $(this).val();
            if (departementId) {
                $.ajax({
                    url: `/api/departements/${departementId}/filieres`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        let options = '<option value="">Sélectionner une filière</option>';
                        $.each(data, function(index, filiere) {
                            options += `<option value="${filiere.id}">${filiere.libelle}</option>`;
                        });
                        $('#filiere_id').html(options).prop('disabled', false);
                    },
                    error: function(xhr, status, error) {
                        console.error('Erreur lors du chargement des filières:', error);
                    }
                });
            } else {
                $('#filiere_id').html('<option value="">Sélectionner d\'abord un département</option>').prop('disabled', true);
            }
        });
    });
</script>
@endpush
