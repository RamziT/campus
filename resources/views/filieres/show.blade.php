@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Détails de la filière: {{ $filiere->libelle }}</h4>
            <div>
                <a href="{{ route('filieres.edit', $filiere->id) }}" class="btn btn-primary">Modifier</a>
                <a href="{{ route('filieres.index') }}" class="btn btn-secondary">Retour</a>
            </div>
        </div>

        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Informations générales</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th>Libellé</th>
                            <td>{{ $filiere->libelle }}</td>
                        </tr>
                        <tr>
                            <th>Abréviation</th>
                            <td>{{ $filiere->abreviation ?: 'Non définie' }}</td>
                        </tr>
                        <tr>
                            <th>Département</th>
                            <td>{{ $filiere->departement->libelle }}</td>
                        </tr>
                        <tr>
                            <th>Statut</th>
                            <td>
                                <span class="badge bg-{{ $filiere->statut == 'active' ? 'success' : 'danger' }}">
                                    {{ $filiere->statut == 'active' ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Date de création</th>
                            <td>{{ $filiere->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Dernière mise à jour</th>
                            <td>{{ $filiere->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <h5>Niveaux</h5>

                    @if($filiere->niveaux->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Libellé</th>
                                        <th>Abréviation</th>
                                        <th>Accessible</th>
                                        <th>Statut</th>
                                        <th>Diplômes requis</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($filiere->niveaux as $niveau)
                                    <tr>
                                        <td>{{ $niveau->libelle }}</td>
                                        <td>{{ $niveau->abreviation }}</td>
                                        <td>
                                            @if($niveau->accessible)
                                                <span class="badge bg-success">Oui</span>
                                            @else
                                                <span class="badge bg-warning">Non</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $niveau->statut == 'active' ? 'success' : 'danger' }}">
                                                {{ $niveau->statut == 'active' ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($niveau->accessible && $niveau->diplomes->count() > 0)
                                                <ul class="mb-0">
                                                    @foreach($niveau->diplomes as $diplome)
                                                        <li>{{ $diplome->libelle }}</li>
                                                    @endforeach
                                                </ul>
                                            @elseif($niveau->accessible)
                                                <em>Aucun diplôme requis</em>
                                            @else
                                                <em>Niveau non accessible</em>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">Aucun niveau n'a été défini pour cette filière.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
