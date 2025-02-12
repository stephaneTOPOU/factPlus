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
                                @if (session('success'))
                                    <script>
                                        $('.widget-content .success').on('click', function() {
                                            Swal.fire({
                                                title: 'Succès',
                                                text: '{{ session('success') }}',
                                                icon: 'success',
                                                confirmButtonText: 'OK'
                                            });
                                        });
                                    </script>
                                @endif


                                <form method="POST" action="{{ route('client.update', $client->id) }}"
                                    enctype="multipart/form-data" id="client-form">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group row  mb-4">
                                        <label for="type_client" class="col-sm-2 col-form-label col-form-label-sm">Type
                                            de client</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="type_client" name="type_client">
                                                <option value="">Choisir le type</option>
                                                <option value="Entreprise"
                                                    {{ old('type_client', $client->type_client ?? '') == 'Entreprise' ? 'selected' : '' }}>
                                                    Entreprise</option>
                                                <option value="Particulier"
                                                    {{ old('type_client', $client->type_client ?? '') == 'Particulier' ? 'selected' : '' }}>
                                                    Particulier</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row  mb-4" id="entreprise_field" style="display: none;">
                                        <label for="entreprise"
                                            class="col-sm-2 col-form-label col-form-label-sm">Entreprise du
                                            client</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control form-control-sm" id="entreprise"
                                                placeholder="Entreprise du client" name="entreprise" required
                                                value="{{ old('entreprise') ?? $client->entreprise }}">
                                        </div>
                                    </div>

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            const typeClientSelect = document.getElementById('type_client');
                                            const entrepriseField = document.getElementById('entreprise_field');
                                            const entrepriseInput = document.getElementById('entreprise');

                                            // Fonction pour afficher/masquer et gérer la validation
                                            function toggleEntrepriseField() {
                                                if (typeClientSelect.value === 'Entreprise') {
                                                    entrepriseField.style.display = 'flex';
                                                    entrepriseInput.setAttribute('required', 'required');
                                                } else {
                                                    entrepriseField.style.display = 'none';
                                                    entrepriseInput.removeAttribute('required');
                                                }
                                            }

                                            // Initialisation au chargement de la page
                                            toggleEntrepriseField();

                                            // Gestion du changement de sélection
                                            typeClientSelect.addEventListener('change', toggleEntrepriseField);
                                        });
                                    </script>


                                    <div class="form-group row  mb-4">
                                        <label for="nom"
                                            class="col-sm-2 col-form-label col-form-label-sm">Nom</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control form-control-sm" id="nom"
                                                placeholder="Nom" name="nom" required
                                                value="{{ old('nom') ?? $client->nom }}">
                                        </div>
                                    </div>

                                    <div class="form-group row  mb-4">
                                        <label for="prenom"
                                            class="col-sm-2 col-form-label col-form-label-sm">Prénom</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control form-control-sm" id="prenom"
                                                placeholder="Prénom" name="prenom" required
                                                value="{{ old('prenom') ?? $client->prenom }}">
                                        </div>
                                    </div>

                                    <div class="form-group row  mb-4">
                                        <label for="email"
                                            class="col-sm-2 col-form-label col-form-label-sm">Email</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control form-control-sm" id="email"
                                                placeholder="Email" name="email" required
                                                value="{{ old('email') ?? $client->email }}">
                                        </div>
                                    </div>

                                    <div class="form-group row  mb-4">
                                        <label for="telephone"
                                            class="col-sm-2 col-form-label col-form-label-sm">Téléphone</label>
                                        <div class="col-sm-10">
                                            <input type="tel" class="form-control form-control-sm" id="telephone"
                                                placeholder="Téléphone" name="telephone" required
                                                value="{{ old('telephone') ?? $client->telephone }}">
                                        </div>
                                    </div>

                                    <div class="form-group row  mb-4">
                                        <label for="adresse"
                                            class="col-sm-2 col-form-label col-form-label-sm">Adresse</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control form-control-sm" id="adresse"
                                                placeholder="Adresse" name="adresse" required
                                                value="{{ old('adresse') ?? $client->adresse }}">
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

<!-- BEGIN THEME GLOBAL STYLE -->
<script src="{{ asset('assets/js/scrollspyNav.js') }}"></script>
<script src="{{ asset('plugins/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('plugins/sweetalerts/custom-sweetalert.js') }}"></script>
<!-- END THEME GLOBAL STYLE -->

@include('Footer.footer3')
