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

<link href="{{ asset('assets/css/components/custom-modal.css') }}" rel="stylesheet" type="text/css" />

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
                                <form method="POST" action="{{ route('facture.store') }}" enctype="multipart/form-data"
                                    id="client-form">
                                    @csrf
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
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
                                        document.getElementById('client_id').addEventListener('change', function() {
                                            const entrepriseField = document.getElementById('entreprise_field');
                                            const entrepriseInput = document.getElementById('entreprise');

                                            const tyField = document.getElementById('ty_field');
                                            const tyInput = document.getElementById('type_client');

                                            const isClientSelected = this.value.trim() !== '';

                                            entrepriseField.style.display = isClientSelected ? 'flex' : 'none';
                                            tyField.style.display = isClientSelected ? 'flex' : 'none';

                                            if (!isClientSelected) {
                                                entrepriseInput.value = '';
                                                tyInput.value = '';
                                            }
                                        });
                                    </script>

                                    <div id="produits">
                                        <div class="form-group row  mb-4 produit-item">
                                            <label for="produit_id"
                                                class="col-sm-2 col-form-label col-form-label-sm">Nom du
                                                produit</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" id="produit_id" name="produit_id">
                                                    <option value="">Choisir un produit</option>
                                                    @foreach ($produits as $produit)
                                                        <option value="{{ $produit->id }}">{{ $produit->nom }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
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
                                            class="col-sm-2 col-form-label col-form-label-sm">Quantité en stock</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control form-control-sm"
                                                id="quantite_stock" placeholder="Quantité en stock"
                                                name="quantite_stock" required readonly>
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

                                                fieldElement.style.display = isProduitSelected ? 'flex' : 'none';

                                                if (!isProduitSelected) {
                                                    inputElement.value = '';
                                                }
                                            });
                                        });
                                    </script>

                                    <div class="form-group row  mb-4">
                                        <label for="quantite"
                                            class="col-sm-2 col-form-label col-form-label-sm">Quantite</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control form-control-sm" id="quantite"
                                                placeholder="Quantite" name="quantite" required>
                                        </div>
                                    </div>
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

                                    <div class="form-group row mb-4">
                                        <label for="date_echeance"
                                            class="col-sm-2 col-form-label col-form-label-sm">Date d'échéance</label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control form-control-sm"
                                                id="date_echeance" placeholder="Date d'échéance" name="date_echeance"
                                                required>
                                            <small id="date_error" class="text-danger" style="display: none;">
                                                La date d'échéance ne peut pas être antérieure à la date d'émission.
                                            </small>
                                        </div>
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                const dateEmission = document.getElementById('date_emission');
                                                const dateEcheance = document.getElementById('date_echeance');
                                                const dateError = document.getElementById('date_error');

                                                if (dateEmission && dateEcheance) {
                                                    dateEmission.addEventListener('change', function() {
                                                        dateEcheance.setAttribute('min', this.value);
                                                        checkDate();
                                                    });

                                                    dateEcheance.addEventListener('change', checkDate);
                                                }

                                                function checkDate() {
                                                    if (dateEmission.value && dateEcheance.value < dateEmission.value) {
                                                        dateError.style.display = "block"; // Afficher le message d'erreur
                                                        dateEcheance.value = ""; // Réinitialiser la valeur incorrecte
                                                    } else {
                                                        dateError.style.display = "none"; // Cacher le message d'erreur
                                                    }
                                                }
                                            });
                                        </script>
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

                                    <!-- Bouton pour ajouter d'autres produits -->
                                    <input type="button" id="addProduit" class="btn btn-secondary"
                                        value="Ajouter un autre produit" data-toggle="modal"
                                        data-target=".bd-example-modal-lg" />

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

    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Ajouter un nouveau
                        produit</h5>

                </div>
                <div class="modal-body">

                    <form id="produitForm">
                        <div class="form-group row  mb-4">
                            <label class="col-sm-2 col-form-label col-form-label-sm" for="produit_id_modal">Nom du
                                Produit</label>
                            <div class="col-sm-10">
                                <select id="produit_id_modal" class="form-control" required name="produit_id">
                                    <option value="">Choisir un produit</option>
                                    @foreach ($produits as $produit)
                                        <option value="{{ $produit->id }}">
                                            {{ $produit->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row  mb-4">
                            <label class="col-sm-2 col-form-label col-form-label-sm"
                                for="quantite_modal">Quantité</label>
                            <div class="col-sm-10">
                                <input type="number" id="quantite_modal" class="form-control" required
                                    min="1" name="quantite">
                            </div>
                        </div>

                        <div class="form-group row  mb-4">
                            <label class="col-sm-2 col-form-label col-form-label-sm" for="tva_modal">TVA (%)</label>
                            <div class="col-sm-10">
                                <input type="number" id="tva_modal" class="form-control" required min="0"
                                    step="0.01" name="tva">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Fermer</button>
                    <button type="button" class="btn btn-primary" id="addProduitBtn">Ajouter</button>
                </div>
            </div>
        </div>
    </div>

</div>

@include('Footer.footer')

<script>
    let produitIndex = 0;

    document.getElementById('addProduitBtn').addEventListener('click', function() {
        const produitId = document.getElementById('produit_id_modal').value;
        const quantite = document.getElementById('quantite_modal').value;
        const tva = document.getElementById('tva_modal').value;

        // Vérifier que toutes les informations sont remplies
        if (produitId && quantite && tva) {
            const produitsContainer = document.getElementById('produits');

            // Récupération du nom du produit sélectionné
            const produitNom = document.querySelector(`#produit_id_modal option[value="${produitId}"]`).text;

            // Création de l'élément produit
            const newProduitItem = document.createElement('div');
            newProduitItem.classList.add('form-group', 'row', 'mb-4', 'produit-item');
            newProduitItem.innerHTML = `
                <div class="col-md-4">
                    <input type="hidden" name="produits[${produitIndex}][produit_id]" value="${produitId}">
                    <span>${produitNom}</span>
                </div>
                <div class="col-md-3">
                    <input type="text" name="produits[${produitIndex}][quantite]" value="${quantite}" class="form-control" readonly>
                </div>
                <div class="col-md-3">
                    <input type="text" name="produits[${produitIndex}][tva]" value="${tva}" class="form-control" readonly>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-produit">Supprimer</button>
                </div>
            `;

            // Ajouter le produit à la liste
            produitsContainer.appendChild(newProduitItem);

            // Ajouter un événement pour supprimer l'élément
            newProduitItem.querySelector('.remove-produit').addEventListener('click', function() {
                this.closest('.produit-item').remove();
            });

            // Réinitialiser les champs du modal
            document.getElementById('produitForm').reset();

            // Fermer le modal
            $('#addProduitModal').modal('hide');

            // Incrémenter l'index pour le prochain produit
            produitIndex++;
        } else {
            alert('Veuillez remplir tous les champs.');
        }
    });
</script>


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
