
{{-- resources/views/diplomes/show.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>{{ __('Détails du diplôme') }}</span>
                        <div>
                            <a href="{{ route('diplomes.edit', $diplome->id) }}" class="btn btn-sm btn-primary">{{ __('Modifier') }}</a>
                            <a href="{{ route('diplomes.index') }}" class="btn btn-sm btn-secondary">{{ __('Retour') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4 font-weight-bold">{{ __('Libellé') }}</div>
                            <div class="col-md-8">{{ $diplome->libelle }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 font-weight-bold">{{ __('Abréviation') }}</div>
                            <div class="col-md-8">{{ $diplome->abreviation ?: 'Non défini' }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 font-weight-bold">{{ __('Série') }}</div>
                            <div class="col-md-8">{{ $diplome->serie ?: 'Non défini' }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 font-weight-bold">{{ __('Spécialité') }}</div>
                            <div class="col-md-8">{{ $diplome->specialite ?: 'Non défini' }}</div>
                        </div>


                        <div class="row mb-3">
                            <div class="col-md-4 font-weight-bold">{{ __('Option') }}</div>
                            <div class="col-md-8">{{ $diplome->option ?: 'Non défini' }}</div>
                        </div>

                        @if($diplome->niveaux->count() > 0)
                            <div class="row mb-3">
                                <div class="col-md-4 font-weight-bold">{{ __('Niveaux accessibles') }}</div>
                                <div class="col-md-8">
                                    <ul class="list-group">
                                        @foreach($diplome->niveaux as $niveau)
                                            <li class="list-group-item">
                                                {{ $niveau->libelle }}
                                                @if($niveau->abreviation) ({{ $niveau->abreviation }}) @endif
                                                - {{ $niveau->filiere->libelle }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <div class="row mb-3">
                            <div class="col-md-4 font-weight-bold">{{ __('Statut') }}</div>
                            <div class="col-md-8">
                                <span class="badge {{ $diplome->statut == 'active' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $diplome->statut == 'active' ? 'Actif' : 'Inactif' }}
                                </span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 font-weight-bold">{{ __('Créé le') }}</div>
                            <div class="col-md-8">{{ $diplome->created_at->format('d/m/Y H:i') }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 font-weight-bold">{{ __('Mis à jour le') }}</div>
                            <div class="col-md-8">{{ $diplome->updated_at->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
