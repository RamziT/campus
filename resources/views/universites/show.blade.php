@extends('layouts.app')

@section('title', 'Détails de l\'université')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Détails de l'université</h1>
        <div>
            <a href="{{ route('universites.index') }}" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left me-1"></i> Retour
            </a>
            <a href="{{ route('universites.edit', $universite) }}" class="btn btn-warning">
                <i class="fas fa-edit me-1"></i> Modifier
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 30%">ID</th>
                            <td>{{ $universite->id }}</td>
                        </tr>
                        <tr>
                            <th>Libellé</th>
                            <td>{{ $universite->libelle }}</td>
                        </tr>
                        <tr>
                            <th>Abréviation</th>
                            <td>{{ $universite->abreviation ?? 'Non défini' }}</td>
                        </tr>
                        <tr>
                            <th>Ville</th>
                            <td>{{ $universite->ville ?? 'Non défini' }}</td>
                        </tr>
                        <tr>
                            <th>Statut</th>
                            <td>
                                @if($universite->statut == 'active')
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 30%">Téléphone</th>
                            <td>{{ $universite->telephone ?? 'Non défini' }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $universite->email ?? 'Non défini' }}</td>
                        </tr>
                        <tr>
                            <th>Site web</th>
                            <td>
                                @if($universite->site_web)
                                    <a href="{{ $universite->site_web }}" target="_blank">{{ $universite->site_web }}</a>
                                @else
                                    Non défini
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Adresse</th>
                            <td>{{ $universite->adresse ?? 'Non défini' }}</td>
                        </tr>
                        {{-- <tr>
                            <th>Date de création</th>
                            <td>{{ $universite->created_at->format('d/m/Y H:i') }}</td>
                        </tr> --}}
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
            <i class="fas fa-trash me-1"></i> Supprimer cette université
        </button>
    </div>

    <!-- Modal de confirmation de suppression -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmation de suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Êtes-vous sûr de vouloir supprimer l'université <strong>{{ $universite->libelle }}</strong> ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <form action="{{ route('universites.destroy', $universite) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
