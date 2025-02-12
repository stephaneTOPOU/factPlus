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
                                    enctype="multipart/form-data" id="client-form">
                                    @csrf
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
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

                                    <div class="form-group row  mb-4" id="status_field" style="display: none;">
                                        <label for="status"
                                            class="col-sm-2 col-form-label col-form-label-sm">Status</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control form-control-sm" id="status"
                                                placeholder="Status" name="status" required readonly>
                                        </div>
                                    </div>

                                    <script>
                                        document.getElementById('facture_id').addEventListener('change', function () {
                                            const statusField = document.getElementById('status_field');
                                            const statusInput = document.getElementById('status');

                                            if (this.value) {
                                                statusField.style.display = 'flex';
                                                statusInput.setAttribute('required', 'required'); // Activer la validation
                                            } else {
                                                statusField.style.display = 'none';
                                                statusInput.removeAttribute('required'); // Désactiver la validation
                                            }
                                        });
                                    </script>

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

                                        <script>
                                            // Obtenez la date actuelle
                                            const today = new Date();
                                            const yyyy = today.getFullYear();
                                            const mm = String(today.getMonth() + 1).padStart(2, '0'); // Mois (0-indexé)
                                            const dd = String(today.getDate()).padStart(2, '0'); // Jour

                                            const todayFormatted = `${yyyy}-${mm}-${dd}`;

                                            // Forcer la date minimum dans l'input date
                                            const dateInput = document.getElementById('date_paiement');
                                            dateInput.setAttribute('min', todayFormatted);

                                            // Optionnel : définir la valeur par défaut à aujourd'hui
                                            dateInput.value = todayFormatted;
                                        </script>

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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('client-form').addEventListener('submit', async function(e) {
        e.preventDefault(); // Empêche le rechargement de la page

        const formData = new FormData(this);
        const csrfToken = document.querySelector('input[name="_token"]').value;

        console.log('FormData:', formData);
        console.log('CSRF Token:', csrfToken);
        try {
            const response = await fetch(this.action, {
                method: this.method,
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                }
            });

            const data = await response.json();

            if (data.success) {
                Swal.fire({
                    title: 'Succès !',
                    text: data.message,
                    type: 'success',
                    confirmButtonText: 'OK',
                    padding: '2em'
                }).then(() => {
                    window.location.reload(); // Recharge la page ou redirige
                });
            } else {
                Swal.fire({
                    title: 'Erreur',
                    text: data.message || 'Une erreur est survenue.',
                    type: 'error',
                    confirmButtonText: 'OK',
                    padding: '2em'
                });
            }
        } catch (error) {
            console.error('Erreur:', error);
            Swal.fire({
                title: 'Erreur',
                text: 'Erreur lors de la soumission.',
                type: 'error',
                confirmButtonText: 'OK',
                padding: '2em'
            });
        }
    });
</script>

<!-- BEGIN THEME GLOBAL STYLE -->
<script src="{{ asset('assets/js/scrollspyNav.js') }}"></script>
<script src="{{ asset('plugins/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('plugins/sweetalerts/custom-sweetalert.js') }}"></script>
<!-- END THEME GLOBAL STYLE -->

@include('Footer.footer3')
