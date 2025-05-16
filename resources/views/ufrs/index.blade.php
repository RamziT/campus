{{-- ufrs/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Gestion des UFR')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gestion des UFR</h1> <a href="{{ route('ufrs.create') }}" class="btn btn-primary"> <i
                class="fas fa-plus me-1"></i> Ajouter une UFR </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card">
        <div class="card-body">
            <table id="ufrs-table" class="table table-striped table-hover table-bordered mt-3 mb-4">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Libellé</th>
                        <th>Abréviation</th>
                        <th>Université</th>
                        {{-- <th>Responsable</th> --}}
                        <th>Contact</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ufrs as $ufr)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $ufr->libelle }}</td>
                        <td>{{ $ufr->abreviation }}</td>
                        <td>{{ $ufr->universite->libelle }}</td>
                        {{-- <td>{{ $ufr->responsable_id }}</td> --}}
                        <td>{{ $ufr->contact }}</td>
                        <td>
                            @if($ufr->statut == 'active')
                            <span class="badge bg-success">Active</span>
                            @else
                            <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('ufrs.show', $ufr) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('ufrs.edit', $ufr) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal{{ $ufr->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>

                            <!-- Modal de confirmation de suppression -->
                            <div class="modal fade" id="deleteModal{{ $ufr->id }}" tabindex="-1"
                                aria-labelledby="deleteModalLabel{{ $ufr->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $ufr->id }}">Confirmation de
                                                suppression</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Êtes-vous sûr de vouloir supprimer l'UFR <strong>{{ $ufr->libelle
                                                }}</strong> ?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Annuler</button>
                                            <form action="{{ route('ufrs.destroy', $ufr) }}" method="POST"
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
                        <th>Université</th>
                        {{-- <th>Responsable</th> --}}
                        <th>Contact</th>
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
        $('#ufrs-table').DataTable({
            dom: '<"top"lBf><"middle"r>t<"bottom"i p><"clear">',
            buttons: [{
                            extend: 'excelHtml5',
                            text: '<i class="fas fa-file-excel"></i> Exporter en Excel',
                            className: 'btn bg-white text-success bg-opacity-25',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6]
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            text: '<i class="fas fa-file-pdf"></i>Exporter vers PDF',
                            className: 'btn bg-white text-danger bg-opacity-25',
                            exportOptions: {
                                columns: [0,1, 2, 3, 4, 5, 6]
                            },
                        customize: function(doc) {
                            var rows = doc.content[1].table.body;
                            rows.forEach(function(row, index) {
                                if (index > 0) {
                                    row[0] = index;
                                }
                            });
                        }
                        }
                    ],
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
                    "sEmptyTable": "Aucune UFR trouvée",
                    "lengthMenu": "Afficher _MENU_ UFR",
                    "sInfo": "Affichage des UFR _START_ à _END_ sur _TOTAL_ UFR",
                    "sInfoEmpty": "Aucune UFR trouvée",
                    "sInfoFiltered": "(filtré à partir de _MAX_ UFR)",
                    "sLoadingRecords": "Chargement...",
                    "sProcessing": "Traitement...",
                    "sSearch": "Rechercher :",
                    "sZeroRecords": "Aucune UFR trouvée",
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
