@include('head.head')
@include('head.head1')
@include('head.head2')

<!-- BEGIN PAGE LEVEL CUSTOM STYLES -->
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/custom_dt_html5.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/dt-global_style.css') }}">
<!-- END PAGE LEVEL CUSTOM STYLES -->

@include('head.head4')
@include('head.head5')

@include('navbar.nav')

<!--  BEGIN MAIN CONTAINER  -->
<div class="main-container sidebar-closed sbar-open" id="container">

    @include('overlay.overlay')

    @include('sidebar.sidebar')

    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">

            <div class="page-header">
                <div class="page-title">
                    <h3>Exportation Devis</h3>
                </div>
            </div>

            <div class="row" id="cancel-row">

                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="widget-content widget-content-area br-6">
                        <div class="row">
                            <div class="col-md-10"></div>
                            <div class="col-md-2">
                                <a href="{{ route('devis.create') }}" class="btn btn-block btn-success pull-right">
                                    Ajouter </a>
                            </div>
                        </div>
                        <div class="table-responsive mb-4 mt-4">
                            <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Référence Devis</th>
                                        <th>Entreprise</th>
                                        <th>Client</th>
                                        <th>Catégorie</th>
                                        <th>Produit</th>
                                        <th>Date d'émission</th>
                                        <th>Date d'écheance</th>
                                        <th>status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($devis as $devi)
                                        <tr>
                                            <td>{{ $devi->reference_devis }}</td>
                                            <td>{{ optional($devi->client)->entreprise ?? 'N/A' }}</td>
                                            <td>{{ $devi->client->nom }}</td>

                                            <td>{{ implode(', ', $devi->detailDevis->pluck('produit.categorie')->unique()->toArray()) }}
                                            </td>
                                            <td>{{ implode(', ', $devi->detailDevis->pluck('produit.nom')->toArray()) }}
                                            </td>

                                            <td>{{ $devi->date_emission }}</td>
                                            <td>{{ $devi->date_echeance }}</td>
                                            <td>{{ $devi->status }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-dark btn-sm">Ouvrir</button>
                                                    <button type="button"
                                                        class="btn btn-dark btn-sm dropdown-toggle dropdown-toggle-split"
                                                        id="dropdownMenuReference1" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false"
                                                        data-reference="parent">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-chevron-down">
                                                            <polyline points="6 9 12 15 18 9"></polyline>
                                                        </svg>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1">
                                                        <a class="dropdown-item"
                                                            href="{{ route('devis.show', $devi->id) }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-maximize-2">
                                                                <polyline points="15 3 21 3 21 9"></polyline>
                                                                <polyline points="9 21 3 21 3 15"></polyline>
                                                                <line x1="21" y1="3" x2="14"
                                                                    y2="10"></line>
                                                                <line x1="3" y1="21" x2="10"
                                                                    y2="14"></line>
                                                            </svg>
                                                            Aperçu
                                                        </a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('devis.edit', $devi->id) }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-edit">
                                                                <path
                                                                    d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                                </path>
                                                                <path
                                                                    d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                                </path>
                                                            </svg>
                                                            Modifier
                                                        </a>
                                                        <a class="dropdown-item" href="#"
                                                            onclick="deleteData({{ $devi->id }})">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-trash-2">
                                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                                <path
                                                                    d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                                </path>
                                                                <line x1="10" y1="11" x2="10"
                                                                    y2="17"></line>
                                                                <line x1="14" y1="11" x2="14"
                                                                    y2="17"></line>
                                                            </svg>
                                                            Supprimer
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <!--  END CONTENT AREA  -->
</div>
<!-- END MAIN CONTAINER -->


@include('Footer.footer')

<!-- BEGIN PAGE LEVEL CUSTOM SCRIPTS -->
<script src="{{ asset('plugins/table/datatable/datatables.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    console.log('Chargé');

    function deleteData(id) {
        const url = "{{ url('devis') }}/" + id;
        const table = $('#html5-extension').DataTable();

        console.log('url généré : ', url);
        console.log('la table : ', table);

        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: "Vous ne pourrez pas revenir en arrière !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, supprimez !'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'DELETE',
                    url: url,
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        console.log("Réponse serveur :", response);
                        Swal.fire(
                            'Supprimé !',
                            response.success,
                            'success'
                        ).then(() => {
                            // Vérifier si DataTable est bien initialisé avant de recharger
                            if ($.fn.DataTable.isDataTable('#html5-extension')) {
                                table.ajax.reload(null, false);
                            } else {
                                console.error("DataTable n'est pas initialisé !");
                            }
                        });
                    },
                    error: function(xhr) {
                        console.error("Erreur AJAX :", xhr);
                        Swal.fire(
                            'Erreur !',
                            'Une erreur est survenue.',
                            'error'
                        );
                    }
                });
            }
        });
    }
</script>

<!-- NOTE TO Use Copy CSV Excel PDF Print Options You Must Include These Files  -->
<script src="{{ asset('plugins/table/datatable/button-ext/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/table/datatable/button-ext/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/table/datatable/button-ext/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/table/datatable/button-ext/buttons.print.min.js') }}"></script>
<script>
    $('#html5-extension').DataTable({
        dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
        buttons: {
            buttons: [{
                    extend: 'copy',
                    className: 'btn'
                },
                {
                    extend: 'csv',
                    className: 'btn'
                },
                {
                    extend: 'excel',
                    className: 'btn'
                },
                {
                    extend: 'print',
                    className: 'btn'
                }
            ]
        },
        "oLanguage": {
            "oPaginate": {
                "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
            },
            "sInfo": "Showing page _PAGE_ of _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Search...",
            "sLengthMenu": "Results :  _MENU_",
        },
        "stripeClasses": [],
        "lengthMenu": [7, 10, 20, 50],
        "pageLength": 7
    });
</script>
<!-- END PAGE LEVEL CUSTOM SCRIPTS -->

@include('Footer.footer3')
