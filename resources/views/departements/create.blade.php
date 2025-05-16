{{-- departements/create.blade.php --}}
@extends('layouts.app')
@section('title', 'Ajouter un département')
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Ajouter un département</h1>
        <a href="{{ route('departements.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Retour à la liste
        </a>
    </div>
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Formulaire d'ajout</h5>
        </div>
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

            <form action="{{ route('departements.store') }}" method="POST">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="universite_id" class="form-label">Université <span
                                    class="text-danger">*</span></label>
                            <select class="form-select tomselect @error('universite_id') is-invalid @enderror" id="universite_id"
                                name="universite_id" required>
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
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="ufr_id" class="form-label">UFR <span class="text-danger">*</span></label>
                            <select class="form-select @error('ufr_id') is-invalid @enderror" id="ufr_id" name="ufr_id"
                                required>
                                <option value="">Sélectionnez d'abord une université</option>
                            </select>
                            @error('ufr_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="libelle" class="form-label">Libellé <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('libelle') is-invalid @enderror" id="libelle"
                                name="libelle" value="{{ old('libelle') }}" required>
                            @error('libelle')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="abreviation" class="form-label">Abréviation</label>
                            <input type="text" class="form-control @error('abreviation') is-invalid @enderror"
                                id="abreviation" name="abreviation" value="{{ old('abreviation') }}">
                            @error('abreviation')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email') }}">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="contact" class="form-label">Contact</label>
                            <input type="text" class="form-control @error('contact') is-invalid @enderror" id="contact"
                                name="contact" value="{{ old('contact') }}">
                            @error('contact')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="responsable_id" class="form-label">Responsable</label>
                            <input type="text" class="form-control @error('responsable_id') is-invalid @enderror"
                                id="responsable_id" name="responsable_id" value="{{ old('responsable_id') }}">
                            @error('responsable_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div> --}}

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="statut" class="form-label">Statut <span class="text-danger">*</span></label>
                            <select class="form-select @error('statut') is-invalid @enderror" id="statut" name="statut"
                                required>
                                <option value="active" {{ old('statut')=='active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('statut')=='inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                            @error('statut')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="reset" class="btn btn-light me-md-2">Réinitialiser</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
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
    });
</script>
@endpush
