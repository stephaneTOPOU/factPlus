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
                                        <h4>CLIENT</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area">
                                <form method="POST" action="{{ route('client.store') }}" enctype="multipart/form-data"
                                    id="client-form">
                                    @csrf
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="form-group row  mb-4">
                                        <label for="type_client" class="col-sm-2 col-form-label col-form-label-sm">Type
                                            de client</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="type_client" name="type_client">
                                                <option value="">Choisir le type</option>
                                                <option value="Entreprise">Entreprise</option>
                                                <option value="Particulier">Particulier</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row  mb-4" id="entreprise_field" style="display: none;">
                                        <label for="entreprise"
                                            class="col-sm-2 col-form-label col-form-label-sm">Entreprise du
                                            client</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control form-control-sm" id="entreprise"
                                                placeholder="Entreprise du client" name="entreprise" required>
                                        </div>
                                    </div>

                                    <script>
                                        document.getElementById('type_client').addEventListener('change', function() {
                                            const entrepriseField = document.getElementById('entreprise_field');
                                            const entrepriseInput = document.getElementById('entreprise');

                                            if (this.value === 'Entreprise') {
                                                entrepriseField.style.display = 'flex';
                                                entrepriseInput.setAttribute('required', 'required'); // Activer la validation
                                            } else {
                                                entrepriseField.style.display = 'none';
                                                entrepriseInput.removeAttribute('required'); // Désactiver la validation
                                            }
                                        });
                                    </script>


                                    <div class="form-group row  mb-4">
                                        <label for="nom"
                                            class="col-sm-2 col-form-label col-form-label-sm">Nom</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control form-control-sm" id="nom"
                                                placeholder="Nom" name="nom" required>
                                        </div>
                                    </div>

                                    <div class="form-group row  mb-4">
                                        <label for="prenom"
                                            class="col-sm-2 col-form-label col-form-label-sm">Prénom</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control form-control-sm" id="prenom"
                                                placeholder="Prénom" name="prenom" required>
                                        </div>
                                    </div>

                                    <div class="form-group row  mb-4">
                                        <label for="email"
                                            class="col-sm-2 col-form-label col-form-label-sm">Email</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control form-control-sm" id="email"
                                                placeholder="Email" name="email" required>
                                            <p id="error-message" style="color: red;"></p>
                                        </div>
                                        <script>
                                            document.getElementById('email').addEventListener('blur', function() {
                                                const email = this.value.trim();
                                                const errorMessage = document.getElementById('error-message');

                                                // Réinitialiser le message d'erreur
                                                errorMessage.textContent = '';

                                                // Vérification du format de l'email
                                                if (!validateEmail(email)) {
                                                    errorMessage.textContent = 'Veuillez entrer une adresse e-mail valide.';
                                                    return;
                                                }

                                                if (email) {
                                                    fetch(`/check-email?email=${encodeURIComponent(email)}`)
                                                        .then(response => {
                                                            if (!response.ok) {
                                                                throw new Error('Erreur serveur');
                                                            }
                                                            return response.json();
                                                        })
                                                        .then(data => {
                                                            if (data.exists) {
                                                                errorMessage.textContent = 'Cet e-mail est déjà utilisé.';
                                                            } else {
                                                                errorMessage.textContent = 'E-mail disponible !';
                                                                errorMessage.style.color = 'green';
                                                            }
                                                        })
                                                        .catch(error => {
                                                            console.error('Erreur:', error);
                                                            errorMessage.textContent = 'Erreur lors de la vérification de l\'e-mail.';
                                                        });
                                                }
                                            });

                                            // Fonction pour valider le format de l'e-mail
                                            function validateEmail(email) {
                                                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                                                return emailRegex.test(email);
                                            }
                                        </script>
                                    </div>

                                    <div class="form-group row  mb-4">
                                        <label for="telephone"
                                            class="col-sm-2 col-form-label col-form-label-sm">Téléphone</label>
                                        <div class="col-sm-10">
                                            <input type="tel" class="form-control form-control-sm" id="telephone"
                                                placeholder="Téléphone" name="telephone" required
                                                pattern="^\+?\d{10,15}$"
                                                title="Veuillez entrer un numéro de téléphone valide (exemple : +228xxxxxxxx)">
                                        </div>

                                        <script>
                                            document.getElementById('telephone').addEventListener('blur', function() {
                                                const phoneNumber = this.value.trim();
                                                const errorMessage = document.getElementById('telephone-error');

                                                // Supprime les anciens messages d'erreur
                                                if (!errorMessage) {
                                                    createErrorMessage(this, "Veuillez entrer un numéro valide.");
                                                }

                                                const phoneRegex = /^\+?\d{10,15}$/;
                                                if (!phoneRegex.test(phoneNumber)) {
                                                    setErrorState(this, "Veuillez entrer un numéro de téléphone valide (10 à 15 chiffres).");
                                                } else {
                                                    clearErrorState(this);
                                                }
                                            });

                                            function createErrorMessage(element, message) {
                                                const errorEl = document.createElement('p');
                                                errorEl.id = 'telephone-error';
                                                errorEl.style.color = 'red';
                                                element.parentNode.appendChild(errorEl);
                                            }

                                            function setErrorState(element, message) {
                                                const errorEl = document.getElementById('telephone-error');
                                                errorEl.textContent = message;
                                            }

                                            function clearErrorState(element) {
                                                const errorEl = document.getElementById('telephone-error');
                                                errorEl.textContent = '';
                                            }
                                        </script>
                                    </div>

                                    <div class="form-group row  mb-4">
                                        <label for="adresse"
                                            class="col-sm-2 col-form-label col-form-label-sm">Adresse</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control form-control-sm" id="adresse"
                                                placeholder="Adresse" name="adresse" required>
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
