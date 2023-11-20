@extends('layouts.sidebar')
@section('tittle', 'dashboard')
@section('page', 'Dashboard')
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <div class="col-xl-9 col-xxl-12">
        <div class="row">

            <div class="col-xl-12">
                <div class="card stacked-2">
                    <div class="card">
                        <div class="card-body">
                            <canvas id="transactionChart1" width="800" height="200"></canvas>
                        </div>
                    </div>
                    <div class="card-header flex-wrap border-0 pb-0 align-items-end">
                        <div class="d-flex align-items-center mb-3 me-3">
                            <svg class="me-3" width="68" height="68" viewBox="0 0 68 68" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M59.4999 31.688V19.8333C59.4999 19.0818 59.2014 18.3612 58.6701 17.8298C58.1387 17.2985 57.418 17 56.6666 17H11.3333C10.5818 17 9.86114 16.7014 9.32978 16.1701C8.79843 15.6387 8.49992 14.9181 8.49992 14.1666C8.49992 13.4152 8.79843 12.6945 9.32978 12.1632C9.86114 11.6318 10.5818 11.3333 11.3333 11.3333H56.6666C57.418 11.3333 58.1387 11.0348 58.6701 10.5034C59.2014 9.97208 59.4999 9.25141 59.4999 8.49996C59.4999 7.74851 59.2014 7.02784 58.6701 6.49649C58.1387 5.96514 57.418 5.66663 56.6666 5.66663H11.3333C9.07891 5.66663 6.9169 6.56216 5.32284 8.15622C3.72878 9.75028 2.83325 11.9123 2.83325 14.1666V53.8333C2.83325 56.0876 3.72878 58.2496 5.32284 59.8437C6.9169 61.4378 9.07891 62.3333 11.3333 62.3333H56.6666C57.418 62.3333 58.1387 62.0348 58.6701 61.5034C59.2014 60.9721 59.4999 60.2514 59.4999 59.5V47.6453C61.1561 47.0683 62.5917 45.9902 63.6076 44.5605C64.6235 43.1308 65.1693 41.4205 65.1693 39.6666C65.1693 37.9128 64.6235 36.2024 63.6076 34.7727C62.5917 33.3431 61.1561 32.265 59.4999 31.688ZM53.8333 56.6666H11.3333C10.5818 56.6666 9.86114 56.3681 9.32978 55.8368C8.79843 55.3054 8.49992 54.5847 8.49992 53.8333V22.1453C9.40731 22.4809 10.3658 22.6572 11.3333 22.6666H53.8333V31.1666H45.3333C43.0789 31.1666 40.9169 32.0622 39.3228 33.6562C37.7288 35.2503 36.8333 37.4123 36.8333 39.6666C36.8333 41.921 37.7288 44.083 39.3228 45.677C40.9169 47.2711 43.0789 48.1666 45.3333 48.1666H53.8333V56.6666ZM56.6666 42.5H45.3333C44.5818 42.5 43.8611 42.2015 43.3298 41.6701C42.7984 41.1387 42.4999 40.4181 42.4999 39.6666C42.4999 38.9152 42.7984 38.1945 43.3298 37.6632C43.8611 37.1318 44.5818 36.8333 45.3333 36.8333H56.6666C57.418 36.8333 58.1387 37.1318 58.6701 37.6632C59.2014 38.1945 59.4999 38.9152 59.4999 39.6666C59.4999 40.4181 59.2014 41.1387 58.6701 41.6701C58.1387 42.2015 57.418 42.5 56.6666 42.5Z" fill="#1EAAE7"/>
                            </svg>
                            <div class="me-auto">
                                <h5 class="fs-20 text-black font-w600">Today's Collection</h5>
                                <span class="text-num text-black font-w600">₦{{number_format(intval($todaydepo *1),2)}}</span>
                            </div>
                        </div>
                        <div class="me-3 mb-3">
                            <p class="fs-14 mb-1">Real-Timer</p>
                            <span class="text-black">{{\Carbon\Carbon::now()}}</span>
                        </div>
                        <div class="me-3 mb-3">
                            <p class="fs-14 mb-1">Business-Name</p>
                            <span class="text-black">{{Auth::user()->business_name}}</span>
                        </div>
                        <span class="fs-20 text-black font-w500 me-3 mb-3">**** **** **** 1234</span>
                    </div>
                    <div class="card-body">
                        <div class="progress mb-4" style="height:18px;">
                            <div class="progress-bar bg-inverse progress-animated" style="width: 40%; height:18px;" role="progressbar">
                                <span class="sr-only">60% Complete</span>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-xl-3 mb-3 col-xxl-6 col-sm-6">
                                <div class="media align-items-center bgl-secondary rounded p-2">
                                    <div class="d-inline-block me-3 position-relative donut-chart-sale2">
                                        <span class="donut2" data-peity='{ "fill": ["rgb(172, 57, 212)", "rgba(255, 255, 255, 0)"],   "innerRadius": 23, "radius": 10}'>3/8</span>
                                        <small class="text-secondary">100%</small>
                                    </div>
                                    <div class="media-body">
                                        <h4 class="fs-15 text-black font-w600 mb-0">My-Report</h4>
{{--                                        <span class="fs-14">$5,412</span>--}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 mb-3 col-xxl-6 col-sm-6">
                                <div class="media bgl-success rounded p-2 align-items-center">
                                    <div class="d-inline-block me-3 position-relative donut-chart-sale2">
                                        <span class="donut2" data-peity='{ "fill": ["rgb(43, 193, 85)", "rgba(255, 255, 255, 0)"],   "innerRadius": 23, "radius": 10}'>8/10</span>
                                        <small class="text-success">74%</small>
                                    </div>
                                    <div class="media-body">
                                        <h4 class="fs-15 text-black font-w600 mb-0">Investment</h4>
                                        <span class="fs-14">Coming Soon</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 mb-3 col-xxl-6 col-sm-6">
                                <div class="media bgl-info rounded p-2 align-items-center">
                                    <div class="d-inline-block me-3 position-relative donut-chart-sale2">
                                        <span class="donut2" data-peity='{ "fill": ["rgb(70, 30, 231)", "rgba(255, 255, 255, 0)"],   "innerRadius": 23, "radius": 10}'>4/10</span>
                                        <small class="text-info">94%</small>
                                    </div>
                                    <div class="media-body">
                                        <h4 class="fs-15 text-black font-w600 mb-0">Transaction</h4>
                                        <span class="fs-14">Check all transaction</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 mb-3 col-xxl-6 col-sm-6">
                                <a class="btn btn-outline-primary rounded d-block btn-lg" data-bs-toggle="modal" data-bs-target="#newspends">Check Wallet</a>
                                <div class="modal fade" id="newspends">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Your Wallet</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal"><span>&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-xl-5 col-xxl-6">
                                                        <div class="widget-stat card">
                                                            <div class="card-body p-4">
                                                                <div class="media ai-icon">
									<span class="me-3 bgl-primary text-primary">
										<!-- <i class="ti-user"></i> -->
										<i class="fa fa-money-check"></i>
									</span>
                                                                    <div class="media-body">
                                                                        <p class="mb-1">Wallet Balance</p>
                                                                        <h4 class="mb-0">₦{{number_format(intval(Auth::user()->wallet *1),2)}}</h4>
                                                                        <span class="badge badge-primary">loading</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
{{--                                                    <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">--}}
{{--                                                        <div class="widget-stat card">--}}
{{--                                                            <div class="card-body p-4">--}}
{{--                                                                <div class="media ai-icon">--}}
{{--									<span class="me-3 bgl-warning text-warning">--}}
{{--									<i class="fa fa-money-check"></i>--}}
{{--									</span>--}}
{{--                                                                    <div class="media-body">--}}
{{--                                                                        <p class="mb-1">Next Settlement</p>--}}
{{--                                                                        <h4 class="mb-0">₦{{number_format(intval($todaydepo *1),2)}}</h4>--}}
{{--                                                                        <span class="badge badge-warning">+100%</span>--}}
{{--                                                                    </div>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary">All Settlement</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="">
        <div class="">
            <div class="alert alert-success">
                    @if ($bus->account_number==1 && $bus->account_name==1)
                        <button class='badge badge-danger' id="virtualButton">Click this section to get your payment Virtual Bank Account </button>

                    <!-- Assuming you have a button with the id 'virtualButton' -->
{{--                    <button id="virtualButton">Click me</button>--}}

                    <script>
                        $(document).ready(function() {
                            $('#virtualButton').click(function() {
                                // Show the loading spinner
                                Swal.fire({
                                    title: 'Processing',
                                    text: 'Please wait...',
                                    icon: 'info',
                                    allowOutsideClick: false,
                                    showConfirmButton: false
                                });

                                // Send the selected value to the '/getOptions' route
                                $.ajax({
                                    url: '{{ url('virtual') }}',
                                    type: 'GET',
                                    success: function(response) {
                                        // Handle the successful response
                                        if (response.status == '1') {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Success',
                                                text: response.message
                                            }).then(() => {
                                                location.reload(); // Reload the page
                                            });
                                        } else {
                                            Swal.fire({
                                                icon: 'info',
                                                title: 'Pending',
                                                text: response.message
                                            });
                                            // Handle any other response status
                                        }
                                    },
                                    error: function(xhr) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Fail',
                                            text: xhr.responseText
                                        });
                                        // Handle any errors
                                        console.log(xhr.responseText);
                                        console.log(xhr);
                                    }
                                });
                            });
                        });
                    </script>

                @else
                        <div class="row column1">
                            <div class="col-md-7 col-lg-6">
                                <div class="card-body">
                                    <ul style="list-style-type:square">
                                        <li class="text-white"><h3 class="text-white"><b>Personal Virtual Account Number</b></h3></li>
                                        <br>
                                        <li class='text-white'><h5 class="text-white"><b>{{$bus->account_name}}</b></h5></li>
                                        <li class='text-white'><h5 class="text-white"><b>Account No:{{$bus->account_number}}</b></h5></li>
                                            <li class='text-white'><h5 class="text-white"><b>Bank:{{$bus->bank}}</b></h5></li>
                                        <br>
                                        <li class='text-white'><h5 class="text-white"><b>Note: All virtual funding are being set automatically</b></h5></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-7 col-lg-6">
                                <div>
                                    <center>
                                        <a href="#">
                                            <img width="200" src="{{asset("user/wall.png")}}"  alt="">
                                        </a>
                                    </center>
                                </div>
                            </div>
                        </div>
                    @endif

            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#virtual').change(function() {
                console.log('Button clicked'); // Add this line
                // Show the loading spinner
                Swal.fire({
                    title: 'Processing',
                    text: 'Please wait...',
                    icon: 'info',
                    allowOutsideClick: false,
                    showConfirmButton: false
                });
                // Send the selected value to the '/getOptions' route
                $.ajax({
                    url: '{{ url('virtual') }}',
                    type: 'GET',
                    success: function(response) {
                        // Handle the successful response
                        if (response.status == '1') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message
                            }).then(() => {
                                location.reload(); // Reload the page
                            });
                        } else {
                            Swal.fire({
                                icon: 'info',
                                title: 'Pending',
                                text: response.message
                            });
                            // Handle any other response status
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'fail',
                            text: xhr.responseText
                        });
                        // Handle any errors
                        console.log(xhr.responseText);
                    }
                });
            });
        });

    </script>

    <script>
        fetch('/transaction')
            .then(response => response.json())
            .then(data => {
                var ctx = document.getElementById('transactionChart').getContext('2d');

                var chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.dates,
                        datasets: [{
                            label: 'Deposit Amount',
                            data: data.amounts,
                            backgroundColor: 'rgba(53, 169, 21, 0.5)',
                            borderColor: 'rgba(53, 169, 21, 1)',
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
        fetch('/transaction1')
            .then(response => response.json())
            .then(data => {
                var ctx = document.getElementById('transactionChart1').getContext('2d');

                var chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.dates,
                        datasets: [{
                            label: 'Wallet Transaction',
                            data: data.amounts,
                            backgroundColor: 'rgb(169,137,21)',
                            borderColor: 'rgb(169,137,21)',
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
