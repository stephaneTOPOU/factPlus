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
                                <form method="POST" action="{{ route('facture.update', $facture->id) }}"
                                    enctype="multipart/form-data" id="client-form">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group row  mb-4">
                                        <label for="client_id" class="col-sm-2 col-form-label col-form-label-sm">Nom du
                                            client</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="client_id" name="client_id">
                                                <option value="">Choisir un client</option>
                                                @foreach ($clients as $client)
                                                    <option value="{{ $client->id }}"
                                                        @if ($client->id == $facture->client_id) selected @endif>
                                                        {{ $client->nom }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row  mb-4" id="ty_field" style="display: none;">
                                        <label for="type_client" class="col-sm-2 col-form-label col-form-label-sm">Type
                                            de client</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control form-control-sm" id="type_client"
                                                placeholder="Type de client" name="type_client" required readonly>
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
                                        document.addEventListener('DOMContentLoaded', function() {
                                            const nomClientSelect = document.getElementById('client_id');

                                            const entrepriseField = document.getElementById('entreprise_field');
                                            const entrepriseInput = document.getElementById('entreprise');

                                            const tyField = document.getElementById('ty_field');
                                            const tyInput = document.getElementById('type_client');

                                            // Fonction pour afficher/masquer et gérer la validation
                                            function toggleEntrepriseField() {
                                                const showFields = !!nomClientSelect.value;

                                                entrepriseField.style.display = showFields ? 'flex' : 'none';
                                                entrepriseInput.required = showFields;

                                                tyField.style.display = showFields ? 'flex' : 'none';
                                                tyInput.required = showFields;
                                            }

                                            // Initialisation au chargement de la page
                                            toggleEntrepriseField();

                                            // Gestion du changement de sélection
                                            nomClientSelect.addEventListener('change', toggleEntrepriseField);
                                        });
                                    </script>

                                    <div class="form-group row  mb-4">
                                        <label for="produit_id" class="col-sm-2 col-form-label col-form-label-sm">Nom du
                                            produit</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="produit_id" name="produit_id">
                                                <option value="">Choisir un produit</option>
                                                @foreach ($produits as $produit)
                                                    @foreach ($facture->DetailsFacture as $detail)
                                                        <option value="{{ $produit->id }}"
                                                            @if ($produit->id == $detail->produit_id) selected @endif>
                                                            {{ $produit->nom }}</option>
                                                    @endforeach
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
                                        document.addEventListener('DOMContentLoaded', function() {
                                            const produitSelect = document.getElementById('produit_id');

                                            const ktField = document.getElementById('kt_field');
                                            const categorieInput = document.getElementById('categorie');

                                            const qteField = document.getElementById('qte_field');
                                            const qteInput = document.getElementById('quantite_stock');

                                            const puField = document.getElementById('pu_field');
                                            const puInput = document.getElementById('prix_unitaire');

                                            // Fonction pour afficher/masquer les champs
                                            function toggleEntrepriseField() {
                                                const showFields = !!produitSelect.value;

                                                ktField.style.display = showFields ? 'flex' : 'none';
                                                categorieInput.required = showFields;

                                                qteField.style.display = showFields ? 'flex' : 'none';
                                                qteInput.required = showFields;

                                                puField.style.display = showFields ? 'flex' : 'none';
                                                puInput.required = showFields;
                                            }

                                            // Initialisation au chargement de la page
                                            toggleEntrepriseField();

                                            // Gestion du changement de sélection
                                            produitSelect.addEventListener('change', toggleEntrepriseField);
                                        });
                                    </script>

                                    <div class="form-group row  mb-4">
                                        <label for="tva"
                                            class="col-sm-2 col-form-label col-form-label-sm">TVA</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control form-control-sm" id="tva"
                                                placeholder="TVA" name="tva" required
                                                @foreach ($facture->DetailsFacture as $detail) value="{{ old('tva') ?? $detail->tva }}" @endforeach>
                                        </div>
                                    </div>

                                    <div class="form-group row  mb-4">
                                        <label for="date_emission"
                                            class="col-sm-2 col-form-label col-form-label-sm">Date d'émission</label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control form-control-sm"
                                                id="date_emission" placeholder="Date d'émission" name="date_emission"
                                                required
                                                value="{{ old('date_emission') ?? $facture->date_emission }}">
                                        </div>
                                    </div>

                                    <div class="form-group row  mb-4">
                                        <label for="date_echeance"
                                            class="col-sm-2 col-form-label col-form-label-sm">Date d'échéance</label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control form-control-sm"
                                                id="date_echeance" placeholder="Date d'échéance" name="date_echeance"
                                                required
                                                value="{{ old('date_echeance') ?? $facture->date_echeance }}">
                                        </div>
                                    </div>

                                    <div class="form-group row  mb-4">
                                        <label for="status"
                                            class="col-sm-2 col-form-label col-form-label-sm">Status</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="status" name="status">
                                                <option value="">Choisir un status</option>
                                                <option value="en attente"
                                                    {{ old('status', $facture->status ?? '') == 'en attente' ? 'selected' : '' }}>
                                                    en attente</option>
                                                <option value="payée"
                                                    {{ old('status', $facture->status ?? '') == 'payée' ? 'selected' : '' }}>
                                                    payée</option>
                                                <option value="annulée"
                                                    {{ old('status', $facture->status ?? '') == 'annulée' ? 'selected' : '' }}>
                                                    annulée</option>
                                            </select>
                                        </div>
                                    </div>

                                    <input type="submit" name="time" required class="btn btn-primary"
                                        value="Modifier">
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

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    // Fonction pour récupérer et remplir les champs de formulaire
    async function fetchData(url, mapping) {
        try {
            const response = await axios.get(url);
            const data = response.data;

            // Map des données vers les champs de formulaire
            for (const [key, value] of Object.entries(mapping)) {
                document.getElementById(key).value = data[value] ?? 'N/A';
            }
        } catch (error) {
            console.error('Erreur lors de la récupération des données :', error);
            alert('Impossible de récupérer les informations.');
        }
    }

    // Précharger les données lors de la mise à jour du formulaire
    window.addEventListener('DOMContentLoaded', function() {
        const clientID = document.getElementById('client_id').value;
        const produitID = document.getElementById('produit_id').value;

        if (clientID) {
            fetchData(`/api/client/${clientID}`, {
                'type_client': 'type_client',
                'entreprise': 'entreprise'
            });
        }

        if (produitID) {
            fetchData(`/api/produit/detail/${produitID}`, {
                'categorie': 'categorie',
                'quantite_stock': 'quantite_stock',
                'prix_unitaire': 'prix_unitaire'
            });
        }
    });

    // Événement pour sélectionner un client
    document.getElementById('client_id').addEventListener('change', function() {
        const clientID = this.value;
        if (clientID) {
            fetchData(`/api/client/${clientID}`, {
                'type_client': 'type_client',
                'entreprise': 'entreprise'
            });
        } else {
            resetClientFields();
        }
    });

    // Événement pour sélectionner un produit
    document.getElementById('produit_id').addEventListener('change', function() {
        const produitID = this.value;
        if (produitID) {
            fetchData(`/api/produit/detail/${produitID}`, {
                'categorie': 'categorie',
                'quantite_stock': 'quantite_stock',
                'prix_unitaire': 'prix_unitaire'
            });
        } else {
            resetProductFields();
        }
    });

    // Fonction pour réinitialiser les champs client
    function resetClientFields() {
        document.getElementById('type_client').value = '';
        document.getElementById('entreprise').value = '';
    }

    // Fonction pour réinitialiser les champs produit
    function resetProductFields() {
        document.getElementById('categorie').value = '';
        document.getElementById('quantite_stock').value = '';
        document.getElementById('prix_unitaire').value = '';
    }

    // Fonction pour mettre à jour les données via une API
    async function updateData(url, payload) {
        try {
            const response = await axios.put(url, payload);
            alert('Données mises à jour avec succès');
        } catch (error) {
            console.error('Erreur lors de la mise à jour des données :', error);
            alert('La mise à jour a échoué.');
        }
    }

    // Bouton de mise à jour du formulaire
    document.getElementById('update-button').addEventListener('click', function() {
        if (!validateForm()) return;

        const payload = {
            type_client: document.getElementById('type_client').value,
            entreprise: document.getElementById('entreprise').value,
            categorie: document.getElementById('categorie').value,
            quantite_stock: document.getElementById('quantite_stock').value,
            prix_unitaire: document.getElementById('prix_unitaire').value
        };

        updateData('/api/form/update', payload);
    });

    // Validation des champs du formulaire
    function validateForm() {
        const typeClient = document.getElementById('type_client').value;
        const entreprise = document.getElementById('entreprise').value;

        if (!typeClient) {
            alert('Veuillez sélectionner un type de client.');
            return false;
        }
        if (!entreprise) {
            alert('Veuillez renseigner le nom de l\'entreprise.');
            return false;
        }
        return true;
    }
</script>


<!-- BEGIN THEME GLOBAL STYLE -->
<script src="{{ asset('assets/js/scrollspyNav.js') }}"></script>
<script src="{{ asset('plugins/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('plugins/sweetalerts/custom-sweetalert.js') }}"></script>
<!-- END THEME GLOBAL STYLE -->

@include('Footer.footer3')
