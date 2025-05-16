{{-- diplomes/show.blade.php --}}
@extends('layouts.app')
@section('title', 'Détails du diplôme')
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Détails du diplôme</h1>
        <div>
            <a href="{{ route('diplomes.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Retour à la liste
            </a>
            <a href="{{ route('diplomes.edit', $diplome) }}" class="btn btn-warning ms-2">
                <i class="fas fa-edit me-1"></i> Modifier
            </a>
        </div>
    </div>
    <div class="row mb-4">
    <!-- Informations générales du diplôme -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Informations du diplôme</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th style="width: 30%">Libellé</th>
                            <td>{{ $diplome->libelle }}</td>
                        </tr>
                        <tr>
                            <th>Abréviation</th>
                            <td>{{ $diplome->abreviation ?? 'Non défini' }}</td>
                        </tr>
                        <tr>
                            <th>Série</th>
                            <td>{{ $diplome->serie ?? 'Non défini' }}</td>
                        </tr>
                        <tr>
                            <th>Spécialité</th>
                            <td>{{ $diplome->specialite ?? 'Non défini' }}</td>
                        </tr>
                        <tr>
                            <th>Option</th>
                            <td>{{ $diplome->option ?? 'Non défini' }}</td>
                        </tr>
                        <tr>
                            <th>Statut</th>
                            <td>
                                @if($diplome->statut == 'active')
                                <span class="badge bg-success">Active</span>
                                @else
                                <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Date de création</th>
                            <td>{{ $diplome->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Dernière modification</th>
                            <td>{{ $diplome->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Niveaux associés -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Niveaux associés</h5>
            </div>
            <div class="card-body">
                @if($diplome->niveaux->count() > 0)
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Niveau</th>
                                <th>Filière</th>
                                <th>Département</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($diplome->niveaux as $index => $niveau)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $niveau->libelle }} ({{ $niveau->abreviation }})</td>
                                <td>{{ $niveau->filiere->libelle }}</td>
                                <td>{{ $niveau->filiere->departement->libelle }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-info">
                        Aucun niveau associé à ce diplôme.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Zone de suppression -->
<div class="card border-danger mt-4">
    <div class="card-header bg-danger text-white">
        <h5 class="mb-0">Zone de danger</h5>
    </div>
    <div class="card-body">
        <p class="text-danger">Attention, la suppression d'un diplôme est irréversible et supprimera également toutes les associations avec les niveaux.</p>
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
            <i class="fas fa-trash me-1"></i> Supprimer ce diplôme
        </button>

        <!-- Modal de confirmation de suppression -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Confirmation de suppression</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Êtes-vous sûr de vouloir supprimer le diplôme <strong>{{ $diplome->libelle }}</strong>
                        @if($diplome->serie)
                            série <strong>{{ $diplome->serie }}</strong>
                        @endif
                        @if($diplome->specialite)
                            spécialité <strong>{{ $diplome->specialite }}</strong>
                        @endif
                        ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <form action="{{ route('diplomes.destroy', $diplome) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
@endsection
