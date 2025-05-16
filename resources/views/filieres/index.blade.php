{{-- filieres/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Gestion des filières')
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gestion des filières</h1>
        <a href="{{ route('filieres.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Ajouter une filière
        </a>
    </div>
    <div class="card">
        <div class="card-body">
            <table id="filieres-table" class="table table-striped table-hover table-bordered mt-3 mb-4">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Libellé</th>
                        <th>Abréviation</th>
                        <th>Département</th>
                        <th>UFR</th>
                        <th>Université</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($filieres as $filiere)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $filiere->libelle }}</td>
                        <td>{{ $filiere->abreviation }}</td>
                        <td>{{ $filiere->departement->libelle }}</td>
                        <td>{{ $filiere->departement->ufr->libelle }}</td>
                        <td>{{ $filiere->departement->ufr->universite->libelle }}</td>
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
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal{{ $filiere->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>

                            <!-- Modal de confirmation de suppression -->
                            <div class="modal fade" id="deleteModal{{ $filiere->id }}" tabindex="-1"
                                aria-labelledby="deleteModalLabel{{ $filiere->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $filiere->id }}">
                                                Confirmation de suppression</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Êtes-vous sûr de vouloir supprimer la filière <strong>{{
                                                $filiere->libelle }}</strong> ?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Annuler</button>
                                            <form action="{{ route('filieres.destroy', $filiere) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Supprimer</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Libellé</th>
                        <th>Abréviation</th>
                        <th>Département</th>
                        <th>UFR</th>
                        <th>Université</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        // Initialiser DataTable après avoir ajouté les données
        $('#filieres-table').DataTable({
            dom: '<"top"lBf><"middle"r>t<"bottom"i p><"clear">',
            buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> Exporter en Excel',
                className: 'btn bg-white text-success bg-opacity-25',
                exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6] // Exclut la colonne des actions
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> Exporter vers PDF',
                className: 'btn bg-white text-danger bg-opacity-25',
                exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6] // Exclut la colonne des actions
                },
                customize: function(doc) {
                    var rows = doc.content[1].table.body;
                    rows.forEach(function(row, index) {
                    if (index > 0) {
                        row[0] = index;
                        }
                    });
                }
            }],
        ordering: true,
        info: true,
        searching: true,
        paging: true,
        pagingType: "full_numbers",
        pageLength: 10,
        lengthMenu: [
            [5, 10, 25, 100, -1],
            [5, 10, 25, 100, "Tous"]
        ],
        autoWidth: false,
        responsive: true,
        processing: true,
        language: {
            "sEmptyTable": "Aucune filière trouvée",
            "lengthMenu": "Afficher _MENU_ filières",
            "sInfo": "Affichage des filières _START_ à _END_ sur _TOTAL_ filières",
            "sInfoEmpty": "Aucune filière assignée",
            "sInfoFiltered": "(filtré à partir de _MAX_ filières)",
            "sLoadingRecords": "Chargement...",
            "sProcessing": "Traitement...",
            "sSearch": "Rechercher :",
            "sZeroRecords": "Aucune filière trouvée",
            "oPaginate": {
                "sFirst": "Premier",
                "sLast": "Dernier",
                "sNext": "Suivant",
                "sPrevious": "Précédent"
            }
        }
    });
});
</script>
@endpush
