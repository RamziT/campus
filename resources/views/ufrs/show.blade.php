{{-- ufrs/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Détails de l\'UFR')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Détails de l'UFR</h1>
        <div> <a href="{{ route('ufrs.index') }}" class="btn btn-secondary me-2"> <i class="fas fa-arrow-left me-1"></i>
                Retour à la liste </a> <a href="{{ route('ufrs.edit', $ufr) }}" class="btn btn-warning"> <i
                    class="fas fa-edit me-1"></i> Modifier </a> </div>
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Informations de l'UFR</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 40%">Libellé:</th>
                            <td>{{ $ufr->libelle }}</td>
                        </tr>
                        <tr>
                            <th>Abréviation:</th>
                            <td>{{ $ufr->abreviation ?? 'Non défini' }}</td>
                        </tr>
                        <tr>
                            <th>Université:</th>
                            <td>{{ $ufr->universite->libelle }}</td>
                        </tr>
                        {{-- <tr>
                            <th>Responsable:</th>
                            <td>{{ $ufr->responsable_id ?? 'Non défini' }}</td>
                        </tr> --}}
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 40%">Contact:</th>
                            <td>{{ $ufr->contact ?? 'Non défini' }}</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>{{ $ufr->email ?? 'Non défini' }}</td>
                        </tr>
                        <tr>
                            <th>Statut:</th>
                            <td>
                                @if($ufr->statut == 'active')
                                <span class="badge bg-success">Active</span>
                                @else
                                <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                        </tr>
                        {{-- <tr>
                            <th>Date de création:</th>
                            <td>{{ $ufr->created_at->format('d/m/Y H:i') }}</td>
                        </tr> --}}
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-between">
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
            <i class="fas fa-trash me-1"></i> Supprimer cette UFR
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
                    Êtes-vous sûr de vouloir supprimer l'UFR <strong>{{ $ufr->libelle }}</strong> ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <form action="{{ route('ufrs.destroy', $ufr) }}" method="POST" class="d-inline">
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
