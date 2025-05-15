{{-- resources/views/niveaux/show.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>{{ __('Détails du niveau') }}</span>
                        <div>
                            <a href="{{ route('niveaux.edit', $niveau->id) }}" class="btn btn-sm btn-primary">{{ __('Modifier') }}</a>
                            <a href="{{ route('niveaux.index') }}" class="btn btn-sm btn-secondary">{{ __('Retour') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4 font-weight-bold">{{ __('Libellé') }}</div>
                            <div class="col-md-8">{{ $niveau->libelle }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 font-weight-bold">{{ __('Abréviation') }}</div>
                            <div class="col-md-8">{{ $niveau->abreviation ?: 'Non défini' }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 font-weight-bold">{{ __('Filière') }}</div>
                            <div class="col-md-8">{{ $niveau->filiere->libelle }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 font-weight-bold">{{ __('Accessible') }}</div>
                            <div class="col-md-8">{{ $niveau->accessible ? 'Oui' : 'Non' }}</div>
                        </div>

                        @if($niveau->accessible && $niveau->diplomes->count() > 0)
                            <div class="row mb-3">
                                <div class="col-md-4 font-weight-bold">{{ __('Diplômes requis') }}</div>
                                <div class="col-md-8">
                                    <ul class="list-group">
                                        @foreach($niveau->diplomes as $diplome)
                                            <li class="list-group-item">
                                                {{ $diplome->libelle }}
                                                @if($diplome->serie) - {{ $diplome->serie }} @endif
                                                @if($diplome->option) ({{ $diplome->option }}) @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <div class="row mb-3">
                            <div class="col-md-4 font-weight-bold">{{ __('Statut') }}</div>
                            <div class="col-md-8">
                                <span class="badge {{ $niveau->statut == 'active' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $niveau->statut == 'active' ? 'Actif' : 'Inactif' }}
                                </span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 font-weight-bold">{{ __('Créé le') }}</div>
                            <div class="col-md-8">{{ $niveau->created_at->format('d/m/Y H:i') }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 font-weight-bold">{{ __('Mis à jour le') }}</div>
                            <div class="col-md-8">{{ $niveau->updated_at->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
