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
                                        <h4>PRODUIT</h4>
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


                                <form method="POST" action="{{ route('produit.store') }}"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group row  mb-4">
                                        <label for="categorie"
                                            class="col-sm-2 col-form-label col-form-label-sm">Catégorie</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control form-control-sm" id="categorie"
                                                placeholder="Catégorie" name="categorie" required>
                                        </div>
                                    </div>

                                    <div class="form-group row  mb-4">
                                        <label for="nom" class="col-sm-2 col-form-label col-form-label-sm">Nom du
                                            Produit</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control form-control-sm" id="nom"
                                                placeholder="Nom du Produit" name="nom" required>
                                        </div>
                                    </div>

                                    <div class="form-group row  mb-4">
                                        <label for="description"
                                            class="col-sm-2 col-form-label col-form-label-sm">Description du
                                            produit</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" id="description" rows="8" placeholder="Description du produit" name="description"
                                                required></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row  mb-4">
                                        <label for="prix_unitaire"
                                            class="col-sm-2 col-form-label col-form-label-sm">Prix unitaire</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control form-control-sm"
                                                id="prix_unitaire" placeholder="Prix unitaire" name="prix_unitaire"
                                                required>
                                        </div>
                                    </div>

                                    <div class="form-group row  mb-4">
                                        <label for="quantite_stock"
                                            class="col-sm-2 col-form-label col-form-label-sm">Quantité du stock</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control form-control-sm"
                                                id="quantite_stock" placeholder="Quantité du stock"
                                                name="quantite_stock" required>
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

<!-- BEGIN THEME GLOBAL STYLE -->
<script src="{{ asset('assets/js/scrollspyNav.js') }}"></script>
<script src="{{ asset('plugins/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('plugins/sweetalerts/custom-sweetalert.js') }}"></script>
<!-- END THEME GLOBAL STYLE -->

@include('Footer.footer3')
