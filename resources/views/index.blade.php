@include('head.head')
@include('head.head1')
@include('head.head2')
@include('head.head3')
@include('head.head4')
@include('head.head5')

<!-- BEGIN LOADER -->
<div id="load_screen">
    <div class="loader">
        <div class="loader-content">
            <div class="spinner-grow align-self-center"></div>
        </div>
    </div>
</div>
<!--  END LOADER -->

@include('navbar.nav')

<!--  BEGIN MAIN CONTAINER  -->
<div class="main-container sidebar-closed sbar-open" id="container">

    @include('overlay.overlay')

    @include('sidebar.sidebar')

    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">

            <div class="row layout-top-spacing">

                <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                    <div class="widget widget-chart-one">
                        <div class="widget-heading">
                            <h5 class="">Revenu</h5>
                            <ul class="tabs tab-pills">
                                <li><a href="javascript:void(0);" id="tb_1" class="tabmenu">Mensuel</a></li>
                            </ul>
                        </div>

                        <div class="widget-content">
                            <div class="tabs tab-content">
                                <div id="content_1" class="tabcontent">
                                    <div id="revenueMonthly"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                    <div class="widget widget-chart-two">
                        <div class="widget-heading">
                            <h5 class="">Sales by Category</h5>
                        </div>
                        <div class="widget-content">
                            <div id="chart-2" class=""></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                    <div class="widget-two">
                        <div class="widget-content">
                            <div class="w-numeric-value">
                                <div class="w-content">
                                    <span class="w-value">Daily sales</span>
                                    <span class="w-numeric-title">Go to columns for details.</span>
                                </div>
                                <div class="w-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-dollar-sign">
                                        <line x1="12" y1="1" x2="12" y2="23"></line>
                                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="w-chart">
                                <div id="daily-sales"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                    <div class="widget-three">
                        <div class="widget-heading">
                            <h5 class="">Summary</h5>
                        </div>
                        <div class="widget-content">

                            <div class="order-summary">

                                <div class="summary-list">
                                    <div class="w-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-shopping-bag">
                                            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                            <line x1="3" y1="6" x2="21" y2="6"></line>
                                            <path d="M16 10a4 4 0 0 1-8 0"></path>
                                        </svg>
                                    </div>
                                    <div class="w-summary-details">

                                        <div class="w-summary-info">
                                            <h6>Income</h6>
                                            <p class="summary-count">$92,600</p>
                                        </div>

                                        <div class="w-summary-stats">
                                            <div class="progress">
                                                <div class="progress-bar bg-gradient-secondary" role="progressbar"
                                                    style="width: 90%" aria-valuenow="90" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <div class="summary-list">
                                    <div class="w-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-tag">
                                            <path
                                                d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z">
                                            </path>
                                            <line x1="7" y1="7" x2="7" y2="7"></line>
                                        </svg>
                                    </div>
                                    <div class="w-summary-details">

                                        <div class="w-summary-info">
                                            <h6>Profit</h6>
                                            <p class="summary-count">$37,515</p>
                                        </div>

                                        <div class="w-summary-stats">
                                            <div class="progress">
                                                <div class="progress-bar bg-gradient-success" role="progressbar"
                                                    style="width: 65%" aria-valuenow="65" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <div class="summary-list">
                                    <div class="w-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-credit-card">
                                            <rect x="1" y="4" width="22" height="16" rx="2"
                                                ry="2"></rect>
                                            <line x1="1" y1="10" x2="23" y2="10">
                                            </line>
                                        </svg>
                                    </div>
                                    <div class="w-summary-details">

                                        <div class="w-summary-info">
                                            <h6>Expenses</h6>
                                            <p class="summary-count">$55,085</p>
                                        </div>

                                        <div class="w-summary-stats">
                                            <div class="progress">
                                                <div class="progress-bar bg-gradient-warning" role="progressbar"
                                                    style="width: 80%" aria-valuenow="80" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-12 col-md-6 col-sm-12 col-12 layout-spacing">
                    <div class="widget-one widget">
                        <div class="widget-content">
                            <div class="w-numeric-value">
                                <div class="w-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-shopping-cart">
                                        <circle cx="9" cy="21" r="1"></circle>
                                        <circle cx="20" cy="21" r="1"></circle>
                                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6">
                                        </path>
                                    </svg>
                                </div>
                                <div class="w-content">
                                    <span class="w-value">3,192</span>
                                    <span class="w-numeric-title">Total Orders</span>
                                </div>
                            </div>
                            <div class="w-chart">
                                <div id="total-orders"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-5 col-lg-12 col-md-6 col-sm-12 col-12 layout-spacing">
                    <div class="widget widget-table-one">
                        <div class="widget-heading">
                            <h5 class="">Transactions</h5>
                        </div>

                        <div class="widget-content">
                            @foreach ($transactions as $transaction)
                                <div class="transactions-list">
                                    <div class="t-item">
                                        <div class="t-company-name">
                                            @if ($transaction->facture->client->type_client == 'Entreprise')
                                                <div class="t-icon">
                                                    <div class="icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-home">
                                                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z">
                                                            </path>
                                                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                                        </svg>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="t-icon">
                                                    <div class="avatar avatar-xl">
                                                        <span class="avatar-title rounded-circle">
                                                            @php
                                                                $nomComplet =
                                                                    $transaction->facture->client->nom .
                                                                    ' ' .
                                                                    $transaction->facture->client->prenom;
                                                                $parties = explode(' ', $nomComplet);
                                                                $initiales = '';

                                                                foreach ($parties as $partie) {
                                                                    $initiales .= strtoupper(substr($partie, 0, 1));
                                                                }

                                                                echo $initiales;
                                                            @endphp

                                                        </span>
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="t-name">
                                                <h4>{{ $transaction->facture->client->nom }}
                                                    {{ $transaction->facture->client->prenom }}</h4>
                                                <p class="meta-date">{{ $transaction->date_paiement }}</p>
                                            </div>
                                        </div>
                                        <div class="t-rate rate-inc">
                                            @if ($transaction->facture->total() > 500.0)
                                                <p><span>{{ $transaction->facture->total() }}</span> <svg
                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" class="feather feather-arrow-up">
                                                        <line x1="12" y1="19" x2="12"
                                                            y2="5"></line>
                                                        <polyline points="5 12 12 5 19 12"></polyline>
                                                    </svg></p>
                                            @else
                                                <p><span>{{ $transaction->facture->total() }}</span> <svg
                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" class="feather feather-arrow-down">
                                                        <line x1="12" y1="5" x2="12"
                                                            y2="19">
                                                        </line>
                                                        <polyline points="19 12 12 19 5 12"></polyline>
                                                    </svg></p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">

                    <div class="widget widget-activity-four">

                        <div class="widget-heading">
                            <h5 class="">Recent Activities</h5>
                        </div>

                        <div class="widget-content">

                            <div class="mt-container mx-auto">
                                <div class="timeline-line">

                                    <div class="item-timeline timeline-primary">
                                        <div class="t-dot" data-original-title="" title="">
                                        </div>
                                        <div class="t-text">
                                            <p><span>Updated</span> Server Logs</p>
                                            <span class="badge badge-danger">Pending</span>
                                            <p class="t-time">Just Now</p>
                                        </div>
                                    </div>

                                    <div class="item-timeline timeline-success">
                                        <div class="t-dot" data-original-title="" title="">
                                        </div>
                                        <div class="t-text">
                                            <p>Send Mail to <a href="javascript:void(0);">HR</a> and <a
                                                    href="javascript:void(0);">Admin</a></p>
                                            <span class="badge badge-success">Completed</span>
                                            <p class="t-time">2 min ago</p>
                                        </div>
                                    </div>

                                    <div class="item-timeline  timeline-danger">
                                        <div class="t-dot" data-original-title="" title="">
                                        </div>
                                        <div class="t-text">
                                            <p>Backup <span>Files EOD</span></p>
                                            <span class="badge badge-danger">Pending</span>
                                            <p class="t-time">14:00</p>
                                        </div>
                                    </div>

                                    <div class="item-timeline  timeline-dark">
                                        <div class="t-dot" data-original-title="" title="">
                                        </div>
                                        <div class="t-text">
                                            <p>Collect documents from <a href="javascript:void(0);">Sara</a></p>
                                            <span class="badge badge-success">Completed</span>
                                            <p class="t-time">16:00</p>
                                        </div>
                                    </div>

                                    <div class="item-timeline  timeline-warning">
                                        <div class="t-dot" data-original-title="" title="">
                                        </div>
                                        <div class="t-text">
                                            <p>Conference call with <a href="javascript:void(0);">Marketing
                                                    Manager</a>.</p>
                                            <span class="badge badge-primary">In progress</span>
                                            <p class="t-time">17:00</p>
                                        </div>
                                    </div>

                                    <div class="item-timeline  timeline-secondary">
                                        <div class="t-dot" data-original-title="" title="">
                                        </div>
                                        <div class="t-text">
                                            <p>Rebooted Server</p>
                                            <span class="badge badge-success">Completed</span>
                                            <p class="t-time">17:00</p>
                                        </div>
                                    </div>

                                    <div class="item-timeline  timeline-warning">
                                        <div class="t-dot" data-original-title="" title="">
                                        </div>
                                        <div class="t-text">
                                            <p>Send contract details to Freelancer</p>
                                            <span class="badge badge-danger">Pending</span>
                                            <p class="t-time">18:00</p>
                                        </div>
                                    </div>

                                    <div class="item-timeline  timeline-dark">
                                        <div class="t-dot" data-original-title="" title="">
                                        </div>
                                        <div class="t-text">
                                            <p>Kelly want to increase the time of the project.</p>
                                            <span class="badge badge-primary">In Progress</span>
                                            <p class="t-time">19:00</p>
                                        </div>
                                    </div>

                                    <div class="item-timeline  timeline-success">
                                        <div class="t-dot" data-original-title="" title="">
                                        </div>
                                        <div class="t-text">
                                            <p>Server down for maintanence</p>
                                            <span class="badge badge-success">Completed</span>
                                            <p class="t-time">19:00</p>
                                        </div>
                                    </div>

                                    <div class="item-timeline  timeline-secondary">
                                        <div class="t-dot" data-original-title="" title="">
                                        </div>
                                        <div class="t-text">
                                            <p>Malicious link detected</p>
                                            <span class="badge badge-warning">Block</span>
                                            <p class="t-time">20:00</p>
                                        </div>
                                    </div>

                                    <div class="item-timeline  timeline-warning">
                                        <div class="t-dot" data-original-title="" title="">
                                        </div>
                                        <div class="t-text">
                                            <p>Rebooted Server</p>
                                            <span class="badge badge-success">Completed</span>
                                            <p class="t-time">23:00</p>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="tm-action-btn">
                                <button class="btn">View All <svg xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-chevron-down">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">

                    <div class="widget widget-account-invoice-one">

                        <div class="widget-heading">
                            <h5 class="">Account Info</h5>
                        </div>

                        <div class="widget-content">
                            <div class="invoice-box">

                                <div class="acc-total-info">
                                    <h5>Balance</h5>
                                    <p class="acc-amount">$470</p>
                                </div>

                                <div class="inv-detail">
                                    <div class="info-detail-1">
                                        <p>Monthly Plan</p>
                                        <p>$ 199.0</p>
                                    </div>
                                    <div class="info-detail-2">
                                        <p>Taxes</p>
                                        <p>$ 17.82</p>
                                    </div>
                                    <div class="info-detail-3 info-sub">
                                        <div class="info-detail">
                                            <p>Extras this month</p>
                                            <p>$ -0.68</p>
                                        </div>
                                        <div class="info-detail-sub">
                                            <p>Netflix Yearly Subscription</p>
                                            <p>$ 0</p>
                                        </div>
                                        <div class="info-detail-sub">
                                            <p>Others</p>
                                            <p>$ -0.68</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="inv-action">
                                    <a href="#" class="btn btn-outline-dark">Summary</a>
                                    <a href="#" class="btn btn-danger">Transfer</a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                    <div class="widget widget-table-two">

                        <div class="widget-heading">
                            <h5 class="">Commandes récentes</h5>
                        </div>

                        <div class="widget-content">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>
                                                <div class="th-content">Client</div>
                                            </th>
                                            <th>
                                                <div class="th-content">Produit</div>
                                            </th>
                                            <th>
                                                <div class="th-content">Facture</div>
                                            </th>
                                            <th>
                                                <div class="th-content th-heading">Prix</div>
                                            </th>
                                            <th>
                                                <div class="th-content">Status</div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td>
                                                    <div class="td-content customer-name"><img
                                                            src="{{ asset('assets/img/profile-7.jpg') }}"
                                                            alt="avatar">{{ $order->client->nom }}
                                                        {{ $order->client->prenom }}</div>
                                                </td>
                                                @foreach ($order->detailsFacture as $detail)
                                                    <td>
                                                        <div class="td-content product-brand">
                                                            {{ $detail->produit->nom }}</div>
                                                    </td>
                                                @endforeach
                                                <td>
                                                    <div class="td-content">#{{ $order->reference_facture }}</div>
                                                </td>
                                                <td>
                                                    <div class="td-content pricing"><span
                                                            class="">{{ $order->total() }}</span>
                                                    </div>
                                                </td>
                                                @if ($order->status == 'payée')
                                                    <td>
                                                        <div class="td-content"><span
                                                                class="badge outline-badge-success">Payée</span></div>
                                                    </td>
                                                @elseif ($order->status == 'en attente')
                                                    <td>
                                                        <div class="td-content"><span
                                                                class="badge outline-badge-primary">En attente</span>
                                                        </div>
                                                    </td>
                                                @else
                                                    <td>
                                                        <div class="td-content"><span
                                                                class="badge outline-badge-danger">Annulée</span></div>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                    <div class="widget widget-table-three">

                        <div class="widget-heading">
                            <h5 class="">Produit le plus vendu</h5>
                        </div>

                        <div class="widget-content">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>
                                                <div class="th-content">Poduitr</div>
                                            </th>
                                            <th>
                                                <div class="th-content">Catégorie</div>
                                            </th>
                                            <th>
                                                <div class="th-content th-heading">Quantiét</div>
                                            </th>
                                            <th>
                                                <div class="th-content th-heading">Prix unitaire</div>
                                            </th>
                                            <th>
                                                <div class="th-content">Total</div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="td-content product-name"><img
                                                        src="{{ asset('assets/img/speaker.jpg') }}"
                                                        alt="product">Speakers</div>
                                            </td>
                                            <td>
                                                <div class="td-content"><span class="pricing">$84.00</span></div>
                                            </td>
                                            <td>
                                                <div class="td-content"><span class="discount-pricing">$10.00</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="td-content">240</div>
                                            </td>
                                            <td>
                                                <div class="td-content"><a href="javascript:void(0);"
                                                        class="">Direct</a></div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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
@include('Footer.footer2')
@include('Footer.footer3')
