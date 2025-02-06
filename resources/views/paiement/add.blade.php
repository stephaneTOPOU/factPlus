@include('head.head')
@include('head.head1')
@include('head.head2')


<!-- BEGIN THEME GLOBAL STYLES -->
<link href="{{ asset('assets/css/scrollspyNav.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('plugins/animate/animate.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('plugins/sweetalerts/promise-polyfill.js') }}"></script>
<link href="{{ asset('plugins/sweetalerts/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('plugins/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/components/custom-sweetalert.css') }}" rel="stylesheet" type="text/css" />
<!-- END THEME GLOBAL STYLES -->

@include('head.head4')
@include('head.head5')

@include('navbar.nav')

<!--  BEGIN MAIN CONTAINER  -->
<div class="main-container sidebar-closed sbar-open" id="container">

    @include('overlay.overlay')

    @include('sidebar.sidebar')

    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <div class="row layout-top-spacing">

            <div class="container">

                <div class="row">

                    <div class="col-lg-12 col-12 layout-spacing">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                        <h4>PAIEMENT</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area">
                                <form method="POST" action="{{ route('paiement.store') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row  mb-4">
                                        <label for="facture_id"
                                            class="col-sm-2 col-form-label col-form-label-sm">Référence
                                            Facture</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="facture_id" name="facture_id">
                                                <option value="">Choisir une facture</option>
                                                @foreach ($factures as $facture)
                                                    <option value="{{ $facture->id }}">
                                                        {{ $facture->reference_facture }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>

                                    <div class="form-group row  mb-4">
                                        <label for="status"
                                            class="col-sm-2 col-form-label col-form-label-sm">Référencement</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control form-control-sm" id="status"
                                                placeholder="Référencement" name="status" required readonly>
                                        </div>
                                    </div>

                                    <div class="form-group row  mb-4">
                                        <label for="moyen_paiement"
                                            class="col-sm-2 col-form-label col-form-label-sm">Moyen de paiement</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control form-control-sm"
                                                id="moyen_paiement" placeholder="Moyen de paiement"
                                                name="moyen_paiement" required>
                                        </div>
                                    </div>



                                    <div class="form-group row  mb-4">
                                        <label for="date_paiement"
                                            class="col-sm-2 col-form-label col-form-label-sm">Date de paiement</label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control form-control-sm"
                                                id="date_paiement" placeholder="Date de paiement" name="date_paiement"
                                                required>
                                        </div>
                                    </div>

                                    <input type="submit" name="time" required class="btn btn-primary"
                                        value="Ajouter">
                                </form>
                            </div>
                        </div>
                    </div>
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


<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    // Listen for product selection
    document.getElementById('facture_id').addEventListener('change', function() {
        const factureID = this.value;

        if (factureID) {
            // Fetch product details using Axios
            axios.get(`/api/facture/${factureID}`)
                .then(response => {
                    const facture = response.data;
                    // document.getElementById('reference_facture').value = facture.reference_facture ?? 'N/A';
                    document.getElementById('status').value = facture.status ?? 'N/A';
                })
                .catch(error => {
                    console.error('Error fetching product data:', error);
                    alert('Impossible de récupérer les informations de la facturation.');
                });
        } else {
            // Clear the input fields if no product is selected
            // document.getElementById('reference_facture').value = '';
            document.getElementById('status').value = '';
        }
    });
</script>

<!-- BEGIN THEME GLOBAL STYLE -->
<script src="{{ asset('assets/js/scrollspyNav.js') }}"></script>
<script src="{{ asset('plugins/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('plugins/sweetalerts/custom-sweetalert.js') }}"></script>
<!-- END THEME GLOBAL STYLE -->

@include('Footer.footer3')
