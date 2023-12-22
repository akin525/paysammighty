@extends('admin.layouts.sidebar')
@section('tittle', 'Admin Dashboard')
@section('page', 'Admin Dashboard')
@section('content')
    <div class="col-xl-6">
        <div class="row">
            <div class="col-xl-8 col-lg-6 col-md-7 col-sm-8">
                <div class="card-bx stacked">
                    <img src="{{asset('user/images/card/card.png')}}" alt="" class="mw-100">
                    <div class="card-info text-white">
                        <p class="mb-1">Payonly Wallet</p>
                        <h2 class="fs-36 text-white mb-sm-4 mb-3">₦{{number_format(intval($paylonybalance *1),2)}}</h2>
                        <hr>
                        <p class="mb-1">MCD Wallet</p>
                        <h2 class="fs-36 text-white mb-sm-4 mb-3">₦{{number_format(intval($mcd *1),2)}}</h2>
                        <hr>
                        <p class="mb-1">Easyaccess Wallet</p>
                        <h2 class="fs-36 text-white mb-sm-4 mb-3">₦{{number_format(intval($easy *1),2)}}</h2>
                        <div class="d-flex">
                            <div class="me-5">
                                <p class="fs-14 mb-1 op6">Today Date</p>
                                <span>{{\Carbon\Carbon::now()}}</span>
                            </div>
                            <div>
                                <p class="fs-14 mb-1 op6">Online</p>
                                <span>{{Auth::user()->username}}</span>
                            </div>
                        </div>
                    </div>
                    <a href="#"><i class="fa fa-caret-down" aria-hidden="true"></i></a>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-5 col-sm-4">
                <div class="card bgl-primary card-body overflow-hidden p-0 d-flex rounded">
                    <div class="p-0 text-center mt-3">
                        <span class="text-black">Recent Collection</span>
                        <h3 class="text-black fs-20 mb-0 font-w600">₦{{number_format(intval($todaycollection *1),2)}}</h3>
                        <br>
                        <hr>
                    <span class="text-black">Paylony Pending Wallet</span>
                        <h3 class="text-black fs-20 mb-0 font-w600">₦{{number_format(intval($paylonypending *1),2)}}</h3>
                        <hr>
                        <span class="text-black">MCD Commission</span>
                        <h3 class="text-black fs-20 mb-0 font-w600">₦{{number_format(intval($mcdc *1),2)}}</h3>
                        <hr>
                        <span class="text-black">Clubkonnect Wallet</span>
                        <h3 class="text-black fs-20 mb-0 font-w600">₦{{number_format(intval($club *1),2)}}</h3>
                        <hr>
                    </div>
{{--                    <canvas id="lineChart" height="300" class="mt-auto line-chart-demo"></canvas>--}}
                </div>
            </div>
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header d-sm-flex d-block border-0 pb-0 flex-wrap">
                        <div class="pr-3 me-auto mb-sm-0 mb-3">
                            <h4 class="fs-20 text-black mb-1">All Collection</h4>
                        </div>

                    </div>
                    <div class="card-body">
                        <canvas id="transactionChart" width="800" height="600"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header d-sm-flex d-block border-0 pb-0">
                        <div class="pr-3 mb-sm-0 mb-3 me-auto">
                            <h4 class="fs-20 text-black mb-1">WALLET</h4>
                            <span class="fs-12">All Merchant Balance</span>
                        </div>
                        <span class="fs-24 text-black font-w600">₦{{number_format(intval($alluserwallet *1),2)}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="row">
            <div class="col-xl-6 col-sm-6">
                <div class="card">
                    <div class="card-header flex-wrap border-0 pb-0">
                        <div class="me-3 mb-2">
                            <p class="fs-14 mb-1">All Deposit</p>
                            <span class="fs-24 text-black font-w600">₦{{number_format(intval($allcollection *1),2)}}</span>
                        </div>
                        <span class="fs-12 mb-2">
										<svg width="21" height="15" viewBox="0 0 21 15" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M0.999939 13.5C1.91791 12.4157 4.89722 9.22772 6.49994 7.5L12.4999 10.5L19.4999 1.5" stroke="#2BC155" stroke-width="2"/>
											<path d="M6.49994 7.5C4.89722 9.22772 1.91791 12.4157 0.999939 13.5H19.4999V1.5L12.4999 10.5L6.49994 7.5Z" fill="url(#paint0_linear)"/>
											<defs>
											<linearGradient id="paint0_linear" x1="10.2499" y1="3" x2="10.9999" y2="13.5" gradientUnits="userSpaceOnUse">
											<stop offset="0" stop-color="#2BC155" stop-opacity="0.73"/>
											<stop offset="1" stop-color="#2BC155" stop-opacity="0"/>
											</linearGradient>
											</defs>
										</svg>
                        </span>
                    </div>
                    <div class="card-body p-0">
                        <canvas id="widgetChart1" height="80"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-sm-6">
                <div class="card">
                    <div class="card-header flex-wrap border-0 pb-0">
                        <div class="me-3 mb-2">
                            <p class="fs-14 mb-1">All Purchase</p>
                            <span class="fs-24 text-black font-w600">₦{{number_format(intval($allpurchase *1),2)}}</span>
                        </div>
                        <span class="fs-12 mb-2">
										<svg width="21" height="15" viewBox="0 0 21 15" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M14.3514 7.5C15.9974 9.37169 19.0572 12.8253 20 14H1V1L8.18919 10.75L14.3514 7.5Z" fill="url(#paint0_linear1)"/>
											<path d="M19.5 13.5C18.582 12.4157 15.6027 9.22772 14 7.5L8 10.5L1 1.5" stroke="#FF2E2E" stroke-width="2" stroke-linecap="round"/>
											<defs>
											<linearGradient id="paint0_linear1" x1="10.5" y1="2.625" x2="9.64345" y2="13.9935" gradientUnits="userSpaceOnUse">
											<stop offset="0" stop-color="#FF2E2E"/>
											<stop offset="1" stop-color="#FF2E2E" stop-opacity="0.03"/>
											</linearGradient>
											</defs>
										</svg>
                        </span>
                    </div>
                    <div class="card-body p-0">
                        <canvas id="widgetChart2" height="80"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-12">
                <div class="card overflow-hidden">
                    <div class="card-header d-sm-flex d-block border-0 pb-0">
                        <div class="mb-sm-0 mb-2">
                            <p class="fs-14 mb-1">This Month Collection</p>
                            <span class="mb-0">
											<svg width="12" height="6" viewBox="0 0 12 6" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M11.9999 6L5.99994 -2.62268e-07L-6.10352e-05 6" fill="#2BC155"/>
											</svg>
											<strong class="fs-24 text-black ms-2 me-3">₦{{number_format(intval($thisweek *1),2)}}</strong></span>
                        </div>
                        <span class="fs-12">
										<svg width="21" height="15" viewBox="0 0 21 15" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M0.999939 13.5C1.91791 12.4157 4.89722 9.22772 6.49994 7.5L12.4999 10.5L19.4999 1.5" stroke="#2BC155" stroke-width="2"/>
											<path d="M6.49994 7.5C4.89722 9.22772 1.91791 12.4157 0.999939 13.5H19.4999V1.5L12.4999 10.5L6.49994 7.5Z" fill="url(#paint0_linear2)"/>
											<defs>
											<linearGradient id="paint0_linear2" x1="10.2499" y1="3" x2="10.9999" y2="13.5" gradientUnits="userSpaceOnUse">
											<stop offset="0" stop-color="#2BC155" stop-opacity="0.73"/>
											<stop offset="1" stop-color="#2BC155" stop-opacity="0"/>
											</linearGradient>
											</defs>
										</svg>
                        </span>
                    </div>
                    <div class="card-body p-0">
                        <canvas id="widgetChart3" height="80"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body pb-1">
                        <div class="row align-items-center">
                            <canvas id="transactionChart1" width="800" height="600"></canvas>
                            <br/>
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header d-sm-flex d-block border-0 pb-0">
                                        <div class="pr-3 mb-sm-0 mb-3 me-auto">
                                            <h4 class="fs-20 text-black mb-1">CHARGE</h4>
                                            <span class="fs-12">All Merchant Charges</span>
                                        </div>
                                        <span class="fs-24 text-black font-w600">₦{{number_format(intval($allcharges *1),2)}}</span>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="{{asset('user/js/dashboard/dashboard-1.js')}}"></script>


    <script>
        fetch('/transactions')
            .then(response => response.json())
            .then(data => {
                var ctx = document.getElementById('transactionChart').getContext('2d');

                var chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.dates,
                        datasets: [{
                            label: 'All Collection',
                            data: data.amounts,
                            backgroundColor: 'rgb(4,108,181)',
                            borderColor: 'rgb(4,108,181)',
                            borderWidth: 1,
                            fill: 'origin' // Fill the area below the line

                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
    </script>
    <script>
        fetch('/transactions1')
            .then(response => response.json())
            .then(data => {
                var ctx = document.getElementById('transactionChart1').getContext('2d');

                var chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.dates,
                        datasets: [{
                            label: 'Purchase Charts',
                            data: data.amounts,
                            backgroundColor: 'rgb(4,108,181)',
                            borderColor: 'rgb(4,108,181)',
                            borderWidth: 1,
                            fill: 'origin' // Fill the area below the line

                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
    </script>
@endsection
