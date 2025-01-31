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
                                <form method="POST" action="{{ route('facture.update',$facture->id) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group row  mb-4">
                                        <label for="client_id" class="col-sm-2 col-form-label col-form-label-sm">Nom du
                                            client</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="client_id" name="client_id">
                                                <option value="">Choisir un client</option>
                                                @foreach ($clients as $client)
                                                    <option value="{{ $client->id }}" @if ($client->id == $facture->client_id) selected @endif>{{ $client->nom }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row  mb-4">
                                        <label for="produit_id" class="col-sm-2 col-form-label col-form-label-sm">Nom du
                                            produit</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="produit_id" name="produit_id">
                                                <option value="">Choisir un produit</option>
                                                @foreach ($produits as $produit)
                                                    @foreach ($facture->DetailsFacture as $detail)
                                                    <option value="{{ $produit->id }}" @if ($produit->id == $detail->produit_id) selected @endif>{{ $produit->nom }}</option>
                                                    @endforeach
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row  mb-4">
                                        <label for="quantite"
                                            class="col-sm-2 col-form-label col-form-label-sm">Quantité</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control form-control-sm"
                                                id="quantite" placeholder="Quantité"
                                                name="quantite" required @foreach ($facture->DetailsFacture as $detail) value="{{ old('quantite') ?? $detail->quantite }}" @endforeach>
                                        </div>
                                    </div>

                                    <div class="form-group row  mb-4">
                                        <label for="prix_unitaire"
                                            class="col-sm-2 col-form-label col-form-label-sm">Prix unitaire</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control form-control-sm"
                                                id="prix_unitaire" placeholder="Prix unitaire"
                                                name="prix_unitaire" required @foreach ($facture->DetailsFacture as $detail) value="{{ old('prix_unitaire') ?? $detail->prix_unitaire }}" @endforeach>
                                        </div>
                                    </div>

                                    <div class="form-group row  mb-4">
                                        <label for="tva"
                                            class="col-sm-2 col-form-label col-form-label-sm">TVA</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control form-control-sm"
                                                id="tva" placeholder="TVA"
                                                name="tva" required @foreach ($facture->DetailsFacture as $detail) value="{{ old('tva') ?? $detail->tva }}" @endforeach>
                                        </div>
                                    </div>

                                    <div class="form-group row  mb-4">
                                        <label for="date_emission"
                                            class="col-sm-2 col-form-label col-form-label-sm">Date d'émission</label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control form-control-sm"
                                                id="date_emission" placeholder="Date d'émission" name="date_emission"
                                                required value="{{ old('date_emission') ?? $facture->date_emission }}">
                                        </div>
                                    </div>

                                    <div class="form-group row  mb-4">
                                        <label for="date_echeance"
                                            class="col-sm-2 col-form-label col-form-label-sm">Date d'échéance</label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control form-control-sm"
                                                id="date_echeance" placeholder="Date d'échéance" name="date_echeance"
                                                required value="{{ old('date_echeance') ?? $facture->date_echeance }}">
                                        </div>
                                    </div>

                                    <div class="form-group row  mb-4">
                                        <label for="status"
                                            class="col-sm-2 col-form-label col-form-label-sm">Status</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="status" name="status">
                                                <option value="">Choisir un status</option>
                                                <option value="en attente" {{ old('status', $facture->status ?? '') == 'en attente' ? 'selected' : '' }}>en attente</option>
                                                <option value="payée" {{ old('status', $facture->status ?? '') == 'payée' ? 'selected' : '' }}>payée</option>
                                                <option value="annulée" {{ old('status', $facture->status ?? '') == 'annulée' ? 'selected' : '' }}>annulée</option>
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

<!-- BEGIN THEME GLOBAL STYLE -->
<script src="{{ asset('assets/js/scrollspyNav.js') }}"></script>
<script src="{{ asset('plugins/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('plugins/sweetalerts/custom-sweetalert.js') }}"></script>
<!-- END THEME GLOBAL STYLE -->

@include('Footer.footer3')
