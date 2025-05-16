{{-- niveaux/show.blade.php --}}
@extends('layouts.app')
@section('title', 'Détails du niveau')
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Détails du niveau</h1>
        <div>
            <a href="{{ route('niveaux.index') }}" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left me-1"></i> Retour à la liste
            </a>
            <a href="{{ route('niveaux.edit', $niveau) }}" class="btn btn-warning">
                <i class="fas fa-edit me-1"></i> Modifier
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Informations sur le niveau</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th class="bg-light" style="width: 30%">Libellé</th>
                            <td>{{ $niveau->libelle }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Abréviation</th>
                            <td>{{ $niveau->abreviation ?? 'Non défini' }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Accessible</th>
                            <td>
                                @if($niveau->accessible)
                                    <span class="badge bg-success">Oui</span>
                                @else
                                    <span class="badge bg-secondary">Non</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light">Statut</th>
                            <td>
                                @if($niveau->statut == 'active')
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light">Date de création</th>
                            <td>{{ $niveau->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Dernière mise à jour</th>
                            <td>{{ $niveau->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Structure académique</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th class="bg-light" style="width: 30%">Filière</th>
                            <td>{{ $niveau->filiere->libelle }} ({{ $niveau->filiere->abreviation }})</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Département</th>
                            <td>{{ $niveau->filiere->departement->libelle }} ({{ $niveau->filiere->departement->abreviation }})</td>
                        </tr>
                        <tr>
                            <th class="bg-light">UFR</th>
                            <td>{{ $niveau->filiere->departement->ufr->libelle }} ({{ $niveau->filiere->departement->ufr->abreviation }})</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Université</th>
                            <td>{{ $niveau->filiere->departement->ufr->universite->libelle }} ({{ $niveau->filiere->departement->ufr->universite->abreviation }})</td>
                        </tr>
                    </table>
                </div>
            </div>

            @if($niveau->accessible)
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Diplômes requis</h5>
                </div>
                <div class="card-body">
                    @if($niveau->diplomes->count() > 0)
                    <ul class="list-group">
                        @foreach($niveau->diplomes as $diplome)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $diplome->libelle }}
                            @if($diplome->statut == 'active')
                                <span class="badge bg-success rounded-pill">Active</span>
                            @else
                                <span class="badge bg-danger rounded-pill">Inactive</span>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <div class="alert alert-info mb-0">
                        Aucun diplôme requis pour ce niveau.
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
