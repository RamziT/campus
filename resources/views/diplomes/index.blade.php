{{-- diplomes/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Gestion des diplômes')
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gestion des diplômes</h1>
        <a href="{{ route('diplomes.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Ajouter un diplôme
        </a>
    </div>
    <div class="card">
        <div class="card-body">
            <table id="diplomes-table" class="table table-striped table-hover table-bordered mt-3 mb-4">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Libellé</th>
                        <th>Abréviation</th>
                        <th>Série</th>
                        <th>Spécialité</th>
                        <th>Option</th>
                        <th>Niveaux associés</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($diplomes as $diplome)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $diplome->libelle }}</td>
                        <td>{{ $diplome->abreviation }}</td>
                        <td>{{ $diplome->serie }}</td>
                        <td>{{ $diplome->specialite }}</td>
                        <td>{{ $diplome->option }}</td>
                        <td>
                            @if($diplome->niveaux->count() > 0)
                            <span class="badge bg-primary">{{ $diplome->niveaux->count() }}</span>
                            @else
                            <span class="badge bg-secondary">0</span>
                            @endif
                        </td>
                        <td>
                            @if($diplome->statut == 'active')
                            <span class="badge bg-success">Active</span>
                            @else
                            <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('diplomes.show', $diplome) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('diplomes.edit', $diplome) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal{{ $diplome->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <!-- Modal de confirmation de suppression -->
                            <div class="modal fade" id="deleteModal{{ $diplome->id }}" tabindex="-1"
                                aria-labelledby="deleteModalLabel{{ $diplome->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $diplome->id }}">
                                                Confirmation de suppression</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Êtes-vous sûr de vouloir supprimer le diplôme <strong>{{ $diplome->libelle
                                                }}</strong>
                                            @if($diplome->serie)
                                            série <strong>{{ $diplome->serie }}</strong>
                                            @endif
                                            @if($diplome->specialite)
                                            spécialité <strong>{{ $diplome->specialite }}</strong>
                                            @endif
                                            ?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Annuler</button>
                                            <form action="{{ route('diplomes.destroy', $diplome) }}" method="POST"
                                                class="d-inline">
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
                        <th>Série</th>
                        <th>Spécialité</th>
                        <th>Option</th>
                        <th>Niveaux associés</th>
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
        $('#diplomes-table').DataTable({
            dom: '<"top"lBf><"middle"r>t<"bottom"i p><"clear">',
            buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> Exporter en Excel',
                className: 'btn bg-white text-success bg-opacity-25',
                exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7] // Exclut la colonne des actions
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> Exporter vers PDF',
                className: 'btn bg-white text-danger bg-opacity-25',
                exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7] // Exclut la colonne des actions
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
            "sEmptyTable": "Aucun diplôme trouvé",
            "lengthMenu": "Afficher _MENU_ diplômes",
            "sInfo": "Affichage des diplômes _START_ à _END_ sur _TOTAL_ diplômes",
            "sInfoEmpty": "Aucun diplôme assigné",
            "sInfoFiltered": "(filtré à partir de _MAX_ diplômes)",
            "sLoadingRecords": "Chargement...",
            "sProcessing": "Traitement...",
            "sSearch": "Rechercher :",
            "sZeroRecords": "Aucun diplôme trouvé",
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
