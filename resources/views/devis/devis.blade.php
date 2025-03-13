@include('head.head')
@include('head.head1')
@include('head.head2')

<!--  BEGIN CUSTOM STYLE FILE  -->
<link href="{{ asset('assets/css/apps/invoice.css') }}" rel="stylesheet" type="text/css" />
<!--  END CUSTOM STYLE FILE  -->

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
            <div class="row invoice layout-top-spacing">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="app-hamburger-container">
                        <div class="hamburger"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-menu chat-menu d-xl-none">
                                <line x1="3" y1="12" x2="21" y2="12"></line>
                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                <line x1="3" y1="18" x2="21" y2="18"></line>
                            </svg></div>
                    </div>
                    <div class="doc-container">
                        <div class="tab-title">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-12">
                                    <div class="search">
                                        <input type="text" class="form-control" placeholder="Search">
                                    </div>
                                    <ul class="nav nav-pills inv-list-container d-block" id="pills-tab" role="tablist">
                                        @foreach ($devis as $devi)
                                            <li class="nav-item">
                                                <div class="nav-link list-actions"
                                                    id="{{ $devi->reference_devis }}"
                                                    data-invoice-id="{{ $devi->reference_devis }}">
                                                    <div class="f-m-body">
                                                        <div class="f-head">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-dollar-sign">
                                                                <line x1="12" y1="1" x2="12"
                                                                    y2="23"></line>
                                                                <path
                                                                    d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6">
                                                                </path>
                                                            </svg>
                                                        </div>
                                                        <div class="f-body">
                                                            <p class="invoice-number">
                                                                {{ $devi->reference_devis }}</p>
                                                            <p class="invoice-customer-name"><span>À :</span>
                                                                {{ $devi->client->nom }}</p>
                                                            </p>
                                                            <p class="invoice-generated-date">Date :
                                                                {{ $devi->date_emission }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="invoice-container">
                            <div class="invoice-inbox">

                                <div class="inv-not-selected">
                                    <p>Ouvrez un devis dans la liste.</p>
                                </div>

                                <div class="invoice-header-section">
                                    <h4 class="inv-number"></h4>
                                    <div class="invoice-action">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-printer action-print" data-toggle="tooltip"
                                            data-placement="top" data-original-title="Reply">
                                            <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                            <path
                                                d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2">
                                            </path>
                                            <rect x="6" y="14" width="12" height="8"></rect>
                                        </svg>
                                    </div>
                                </div>

                                <div id="ct" class="">
                                    @foreach ($devis as $devi)
                                        <div class="{{ $devi->reference_devis }}">
                                            <div class="content-section  animated animatedFadeInUp fadeInUp">

                                                <div class="row inv--head-section">

                                                    <div class="col-sm-6 col-12">
                                                        <h3 class="in-heading">DEVIS</h3>
                                                    </div>
                                                    <div class="col-sm-6 col-12 align-self-center text-sm-right">
                                                        <div class="company-info">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-hexagon">
                                                                <path
                                                                    d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                                                                </path>
                                                            </svg>
                                                            <h5 class="inv-brand-name">CORK</h5>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="row inv--detail-section">

                                                    <div class="col-sm-7 align-self-center">
                                                        <p class="inv-to">Devis à</p>
                                                    </div>
                                                    <div
                                                        class="col-sm-5 align-self-center  text-sm-right order-sm-0 order-1">
                                                        <p class="inv-detail-title">De :
                                                            {{ $devi->client->entreprise }}</p>
                                                    </div>

                                                    <div class="col-sm-7 align-self-center">
                                                        <p class="inv-customer-name">{{ $devi->client->nom }}
                                                            {{ $devi->client->prenom }}
                                                        </p>
                                                        <p class="inv-street-addr">{{ $devi->client->adresse }}
                                                        </p>
                                                        <p class="inv-email-address">{{ $devi->client->email }}
                                                        </p>
                                                    </div>
                                                    <div class="col-sm-5 align-self-center  text-sm-right order-2">
                                                        <p class="inv-list-number"><span class="inv-title">Devis
                                                                Number
                                                                : </span> <span
                                                                class="inv-number">[{{ $devi->reference_devis }}]</span>
                                                        </p>
                                                        <p class="inv-created-date"><span class="inv-title">Date
                                                                démission :
                                                            </span> <span
                                                                class="inv-date">{{ $devi->date_emission }}</span>
                                                        </p>
                                                        <p class="inv-due-date"><span class="inv-title">Date
                                                                d'échéance :
                                                            </span>
                                                            <span
                                                                class="inv-date">{{ $devi->date_echeance }}</span>
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="row inv--product-table-section">
                                                    <div class="col-12">
                                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <thead class="">
                                                                    <tr>
                                                                        <th scope="col">Ref.Dev</th>
                                                                        <th scope="col">Produit</th>
                                                                        <th class="text-right" scope="col">Qte
                                                                        </th>
                                                                        <th class="text-right" scope="col">Prix
                                                                            unitaire
                                                                        </th>
                                                                        <th class="text-right" scope="col">
                                                                            Montant</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($devi->detailDevis as $detail)
                                                                        <tr>
                                                                            <td>{{ $devi->reference_devis }}</td>
                                                                            <td>{{ $detail->produit->nom }}</td>
                                                                            <td class="text-right">
                                                                                {{ $detail->quantite }}</td>
                                                                            <td class="text-right">
                                                                                {{ number_format($detail->produit->prix_unitaire, 2, '.', ' ') }}
                                                                            </td>
                                                                            <td class="text-right">
                                                                                {{ number_format($detail->quantite * $detail->produit->prix_unitaire, 2, '.', ' ') }}
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-4">
                                                    <div class="col-sm-5 col-12 order-sm-0 order-1">
                                                        <div class="inv--payment-info">
                                                            <div class="row">
                                                                <div class="col-sm-12 col-12">
                                                                    <h6 class="inv-title">Détails du produit :
                                                                    </h6>
                                                                </div>
                                                                @foreach ($devi->detailDevis as $detail)
                                                                    <div class="col-sm-4 col-12">
                                                                        <p class="inv-subtitle">Catégorie :</p>
                                                                    </div>
                                                                    <div class="col-sm-8 col-12">
                                                                        <p>{{ $detail->produit->categorie }}</p>
                                                                    </div>
                                                                    <div class="col-sm-4 col-12">
                                                                        <p class="inv-subtitle">Description :</p>
                                                                    </div>
                                                                    <div class="col-sm-8 col-12">
                                                                        <p>{{ $detail->description }}</p>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-7 col-12 order-sm-1 order-0">
                                                        <div class="inv--total-amounts text-sm-right">
                                                            <div class="row">
                                                                <div class="col-sm-8 col-7">
                                                                    <p class="">Sous-total : </p>
                                                                </div>
                                                                <div class="col-sm-4 col-5">
                                                                    <p class="">
                                                                        {{ number_format($devi->montantHT(), 2, '.', ' ') }}
                                                                    </p>
                                                                </div>
                                                                <div class="col-sm-8 col-7">
                                                                    <p class="">Montant de la taxe : </p>
                                                                </div>
                                                                <div class="col-sm-4 col-5">
                                                                    <p class="">
                                                                        {{ number_format($devi->tva(), 2, '.', ' ') }}
                                                                    </p>
                                                                </div>
                                                                <div class="col-sm-8 col-7 grand-total-title">
                                                                    <h4 class="">Total : </h4>
                                                                </div>
                                                                <div class="col-sm-4 col-5 grand-total-amount">
                                                                    <h4 class="">
                                                                        {{ number_format($devi->total(), 2, '.', ' ') }}
                                                                    </h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                            </div>

                            <div class="inv--thankYou">
                                <div class="row">
                                    <div class="col-sm-12 col-12">
                                        <p class="">Merci de faire affaire avec nous.</p>
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

<script src="{{ asset('assets/js/apps/invoice.js') }}"></script>

@include('Footer.footer3')
