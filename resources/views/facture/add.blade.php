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
                                        <h4>FACTURE</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area">
                                <form method="POST" action="{{ route('facture.store') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row  mb-4">
                                        <label for="client_id" class="col-sm-2 col-form-label col-form-label-sm">Nom du
                                            client</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="client_id" name="client_id">
                                                <option value="">Choisir un client</option>
                                                @foreach ($clients as $client)
                                                    <option value="{{ $client->id }}">{{ $client->nom }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row  mb-4" id="ty_field" style="display: none;">
                                        <label for="type_client" class="col-sm-2 col-form-label col-form-label-sm">Type
                                            de client</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control form-control-sm" id="type_client"
                                                placeholder="Entreprise du client" name="type_client" required readonly>
                                        </div>
                                    </div>

                                    <div class="form-group row  mb-4" id="entreprise_field" style="display: none;">
                                        <label for="entreprise"
                                            class="col-sm-2 col-form-label col-form-label-sm">Entreprise du
                                            client</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control form-control-sm" id="entreprise"
                                                placeholder="Entreprise du client" name="entreprise" required readonly>
                                        </div>
                                    </div>

                                    <script>
                                        document.getElementById('client_id').addEventListener('change', function() {
                                            const entrepriseField = document.getElementById('entreprise_field');
                                            const entrepriseInput = document.getElementById('entreprise');

                                            const tyField = document.getElementById('ty_field');
                                            const tySelect = document.getElementById('type_client');

                                            const isClientSelected = this.value.trim() !== '';

                                            // Gestion de l'affichage et de la validation
                                            entrepriseField.style.display = isClientSelected ? 'flex' : 'none';
                                            entrepriseInput.toggleAttribute('required', isClientSelected);

                                            tyField.style.display = isClientSelected ? 'flex' : 'none';
                                            tySelect.toggleAttribute('required', isClientSelected);
                                        });
                                    </script>

                                    <div class="form-group row  mb-4">
                                        <label for="produit_id" class="col-sm-2 col-form-label col-form-label-sm">Nom du
                                            produit</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="produit_id" name="produit_id">
                                                <option value="">Choisir un produit</option>
                                                @foreach ($produits as $produit)
                                                    <option value="{{ $produit->id }}">{{ $produit->nom }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row  mb-4" id="kt_field" style="display: none;">
                                        <label for="categorie"
                                            class="col-sm-2 col-form-label col-form-label-sm">Catégorie</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control form-control-sm" id="categorie"
                                                placeholder="Catégorie" name="categorie" required readonly>
                                        </div>
                                    </div>

                                    <div class="form-group row  mb-4" id="qte_field" style="display: none;">
                                        <label for="quantite_stock"
                                            class="col-sm-2 col-form-label col-form-label-sm">Quantité</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control form-control-sm"
                                                id="quantite_stock" placeholder="Quantité" name="quantite_stock"
                                                required readonly>
                                        </div>
                                    </div>

                                    <div class="form-group row  mb-4" id="pu_field" style="display: none;">
                                        <label for="prix_unitaire"
                                            class="col-sm-2 col-form-label col-form-label-sm">Prix unitaire</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control form-control-sm"
                                                id="prix_unitaire" placeholder="Prix unitaire" name="prix_unitaire"
                                                required readonly>
                                        </div>
                                    </div>

                                    <script>
                                        document.getElementById('produit_id').addEventListener('change', function() {
                                            const fields = [{
                                                    field: 'kt_field',
                                                    input: 'categorie'
                                                },
                                                {
                                                    field: 'qte_field',
                                                    input: 'quantite_stock'
                                                },
                                                {
                                                    field: 'pu_field',
                                                    input: 'prix_unitaire'
                                                }
                                            ];

                                            const isProduitSelected = this.value.trim() !== '';

                                            fields.forEach(({
                                                field,
                                                input
                                            }) => {
                                                const fieldElement = document.getElementById(field);
                                                const inputElement = document.getElementById(input);

                                                // Afficher ou masquer les champs et activer/désactiver la validation
                                                fieldElement.style.display = isProduitSelected ? 'flex' : 'none';
                                                inputElement.toggleAttribute('required', isProduitSelected);
                                            });
                                        });
                                    </script>

                                    <div class="form-group row  mb-4">
                                        <label for="tva"
                                            class="col-sm-2 col-form-label col-form-label-sm">TVA</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control form-control-sm" id="tva"
                                                placeholder="TVA" name="tva" required>
                                        </div>
                                    </div>

                                    <div class="form-group row  mb-4">
                                        <label for="date_emission"
                                            class="col-sm-2 col-form-label col-form-label-sm">Date d'émission</label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control form-control-sm"
                                                id="date_emission" placeholder="Date d'émission" name="date_emission"
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
                                            const dateInput = document.getElementById('date_emission');
                                            dateInput.setAttribute('min', todayFormatted);

                                            // Optionnel : définir la valeur par défaut à aujourd'hui
                                            dateInput.value = todayFormatted;
                                        </script>
                                    </div>

                                    <div class="form-group row  mb-4">
                                        <label for="date_echeance"
                                            class="col-sm-2 col-form-label col-form-label-sm">Date d'échéance</label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control form-control-sm"
                                                id="date_echeance" placeholder="Date d'échéance" name="date_echeance"
                                                required>
                                        </div>
                                    </div>

                                    <div class="form-group row  mb-4">
                                        <label for="status"
                                            class="col-sm-2 col-form-label col-form-label-sm">Status</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="status" name="status">
                                                <option value="">Choisir un status</option>
                                                <option value="en attente">en attente</option>
                                                <option value="payée">payée</option>
                                                <option value="annulée">annulée</option>
                                            </select>
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
    async function fetchData(url, mapping) {
        try {
            const response = await axios.get(url);
            const data = response.data;

            // Map data to inputs
            for (const [key, value] of Object.entries(mapping)) {
                document.getElementById(key).value = data[value] ?? 'N/A';
            }
        } catch (error) {
            console.error('Erreur lors de la récupération des données :', error);
            alert('Impossible de récupérer les informations.');
        }
    }

    // Client selection event
    document.getElementById('client_id').addEventListener('change', function() {
        const clientID = this.value;
        if (clientID) {
            fetchData(`/api/client/${clientID}`, {
                'type_client': 'type_client',
                'entreprise': 'entreprise'
            });
        } else {
            document.getElementById('type_client').value = '';
            document.getElementById('entreprise').value = '';
        }
    });

    // Product selection event
    document.getElementById('produit_id').addEventListener('change', function() { // Correction ici
        const produitID = this.value;
        if (produitID) {
            fetchData(`/api/produit/detail/${produitID}`, {
                'categorie': 'categorie',
                'quantite_stock': 'quantite_stock',
                'prix_unitaire': 'prix_unitaire'
            });
        } else {
            document.getElementById('categorie').value = '';
            document.getElementById('quantite_stock').value = '';
            document.getElementById('prix_unitaire').value = '';
        }
    });
</script>



<!-- BEGIN THEME GLOBAL STYLE -->
<script src="{{ asset('assets/js/scrollspyNav.js') }}"></script>
<script src="{{ asset('plugins/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('plugins/sweetalerts/custom-sweetalert.js') }}"></script>
<!-- END THEME GLOBAL STYLE -->

@include('Footer.footer3')
