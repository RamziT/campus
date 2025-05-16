{{-- departements/show.blade.php --}}
@extends('layouts.app')
@section('title', 'Détails du département')
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Détails du département</h1>
        <div>
            <a href="{{ route('departements.index') }}" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left me-1"></i> Retour à la liste
            </a>
            <a href="{{ route('departements.edit', $departement) }}" class="btn btn-warning">
                <i class="fas fa-edit me-1"></i> Modifier
            </a>
        </div>
    </div>
    <div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Informations du département</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th class="bg-light" style="width: 30%">Libellé</th>
                        <td>{{ $departement->libelle }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Abréviation</th>
                        <td>{{ $departement->abreviation ?? 'Non défini' }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">UFR</th>
                        <td>{{ $departement->ufr->libelle }} ({{ $departement->ufr->abreviation }})</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Université</th>
                        <td>{{ $departement->ufr->universite->libelle }} ({{ $departement->ufr->universite->abreviation }})</td>
                    </tr>
                    {{-- <tr>
                        <th class="bg-light">Responsable</th>
                        <td>{{ $departement->responsable_id ?? 'Non défini' }}</td>
                    </tr> --}}
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th class="bg-light" style="width: 30%">Contact</th>
                        <td>{{ $departement->contact ?? 'Non défini' }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Email</th>
                        <td>{{ $departement->email ?? 'Non défini' }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Statut</th>
                        <td>
                            @if($departement->statut == 'active')
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                    </tr>
                    {{-- <tr>
                        <th class="bg-light">Créé le</th>
                        <td>{{ $departement->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Dernière mise à jour</th>
                        <td>{{ $departement->updated_at->format('d/m/Y H:i') }}</td>
                    </tr> --}}
                </table>
            </div>
        </div>
    </div>
</div>

@if($departement->filieres && $departement->filieres->count() > 0)
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Filières du département</h5>
    </div>
    <div class="card-body">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Libellé</th>
                    <th>Abréviation</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($departement->filieres as $index => $filiere)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $filiere->libelle }}</td>
                    <td>{{ $filiere->abreviation }}</td>
                    <td>
                        @if($filiere->statut == 'active')
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="{{ route('filieres.show', $filiere) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('filieres.edit', $filiere) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@else
<div class="alert alert-info">
    <i class="fas fa-info-circle me-2"></i> Aucune filière n'est associée à ce département.
</div>
@endif
</div>
@endsection

