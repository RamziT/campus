{{-- ufrs/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Modifier une UFR')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Modifier l'UFR</h1>
        <div> <a href="{{ route('ufrs.show', $ufr) }}" class="btn btn-info me-2"> <i class="fas fa-eye me-1"></i> Voir
                détails </a> <a href="{{ route('ufrs.index') }}" class="btn btn-secondary"> <i
                    class="fas fa-arrow-left me-1"></i> Retour à la liste </a> </div>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Modifier les informations de l'UFR</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('ufrs.update', $ufr) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="universite_id" class="form-label">Université <span
                                    class="text-danger">*</span></label>
                            <select class="form-select @error('universite_id') is-invalid @enderror" id="universite_id"
                                name="universite_id" required>
                                <option value="">Sélectionner une université</option>
                                @foreach($universites as $universite)
                                <option value="{{ $universite->id }}" {{ old('universite_id', $ufr->universite_id) ==
                                    $universite->id ? 'selected' : '' }}>
                                    {{ $universite->libelle }}
                                </option>
                                @endforeach
                            </select>
                            @error('universite_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    {{-- <div class="col-md-6">
                        <div class="mb-3">
                            <label for="responsable_id" class="form-label">Responsable</label>
                            <input type="text" class="form-control @error('responsable_id') is-invalid @enderror"
                                id="responsable_id" name="responsable_id"
                                value="{{ old('responsable_id', $ufr->responsable_id) }}">
                            @error('responsable_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div> --}}
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="libelle" class="form-label">Libellé <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('libelle') is-invalid @enderror" id="libelle"
                                name="libelle" value="{{ old('libelle', $ufr->libelle) }}" required>
                            @error('libelle')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="abreviation" class="form-label">Abréviation</label>
                            <input type="text" class="form-control @error('abreviation') is-invalid @enderror"
                                id="abreviation" name="abreviation" value="{{ old('abreviation', $ufr->abreviation) }}">
                            @error('abreviation')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="universite_id" class="form-label">Université <span
                                    class="text-danger">*</span></label>
                            <select class="form-select @error('universite_id') is-invalid @enderror" id="universite_id"
                                name="universite_id" required>
                                <option value="">Sélectionner une université</option>
                                @foreach($universites as $universite)
                                <option value="{{ $universite->id }}" {{ old('universite_id', $ufr->universite_id) ==
                                    $universite->id ? 'selected' : '' }}>
                                    {{ $universite->libelle }}
                                </option>
                                @endforeach
                            </select>
                            @error('universite_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    {{-- <div class="col-md-6">
                        <div class="mb-3">
                            <label for="responsable_id" class="form-label">Responsable</label>
                            <input type="text" class="form-control @error('responsable_id') is-invalid @enderror"
                                id="responsable_id" name="responsable_id"
                                value="{{ old('responsable_id', $ufr->responsable_id) }}">
                            @error('responsable_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div> --}}
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="contact" class="form-label">Contact</label>
                            <input type="text" class="form-control @error('contact') is-invalid @enderror" id="contact"
                                name="contact" value="{{ old('contact', $ufr->contact) }}">
                            @error('contact')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email', $ufr->email) }}">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="statut" class="form-label">Statut <span class="text-danger">*</span></label>
                            <select class="form-select @error('statut') is-invalid @enderror" id="statut" name="statut"
                                required>
                                <option value="active" {{ old('statut', $ufr->statut) == 'active' ? 'selected' : ''
                                    }}>Active</option>
                                <option value="inactive" {{ old('statut', $ufr->statut) == 'inactive' ? 'selected' : ''
                                    }}>Inactive</option>
                            </select>
                            @error('statut')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="reset" class="btn btn-secondary me-md-2">
                        <i class="fas fa-undo me-1"></i> Réinitialiser
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
