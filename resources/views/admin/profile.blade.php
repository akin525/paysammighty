@extends('admin.layouts.sidebar')
@section('tittle', $user->username)
@section('page', $user->username)
@section('content')
    <style>
        .subscribe {
            position: relative;
            padding: 20px;
            background-color: #FFF;
            border-radius: 4px;
            color: #333;
            box-shadow: 0px 0px 60px 5px rgba(0, 0, 0, 0.4);
        }

        .subscribe:after {
            position: absolute;
            content: "";
            right: -10px;
            bottom: 18px;
            width: 0;
            height: 0;
            border-left: 0px solid transparent;
            border-right: 10px solid transparent;
            border-bottom: 10px solid #208b37;
        }

        .subscribe p {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 4px;
            line-height: 28px;
        }



        .subscribe .submit-btn {
            position: absolute;
            border-radius: 30px;
            border-bottom-right-radius: 0;
            border-top-right-radius: 0;
            background-color: #208b37;
            color: #FFF;
            padding: 12px 25px;
            display: inline-block;
            font-size: 12px;
            font-weight: bold;
            letter-spacing: 5px;
            right: -10px;
            bottom: -20px;
            cursor: pointer;
            transition: all .25s ease;
            box-shadow: -5px 6px 20px 0px rgba(26, 26, 26, 0.4);
        }

        .subscribe .submit-btn:hover {
            background-color: #208b37;
            box-shadow: -5px 6px 20px 0px rgba(88, 88, 88, 0.569);
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <div class="row">
        <div class="col-lg-12">
            <div class="profile card card-body px-3 pt-3 pb-0">
                <div class="profile-head">
                    <div class="photo-content">
                        <div class="cover-photo rounded"></div>
                    </div>
                    <div class="profile-info">
                        <div class="profile-photo">
                            <img src="{{asset('user/images/avatar/1.png')}}" class="img-fluid rounded-circle" alt="">
                        </div>
                        <div class="profile-details">
                            <div class="profile-name px-3 pt-2">
                                <h4 class="text-primary mb-0">{{$user->business_name}}</h4>
                                <p>{{$user->name}}</p>
                            </div>
                            <div class="profile-email px-2 pt-2">
                                <h4 class="text-muted mb-0">{{$user->email}}</h4>
                                <p>Email</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-4">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="profile-interest">
                                <h5 class="text-primary d-inline">Account Details</h5>
                                <div class="basic-list-group">
                                    <div class="list-group"><a href="javascript:void(0);" class="list-group-item list-group-item-action active">Account
                                            Number </a><a href="javascript:void(0);" class="list-group-item list-group-item-action">
                                            {{$bus->account_number}}</a>
                                        <a href="javascript:void(0);" class="list-group-item list-group-item-action disabled">
                                            Account Name
                                        </a> <a href="javascript:void(0);" class="list-group-item list-group-item-action">{{$bus->account_name}}</a>
                                        <a href="javascript:void(0);" class="list-group-item list-group-item-action active">
                                            Bank
                                        </a>
                                        <a href="javascript:void(0);" class="list-group-item list-group-item-action">{{$bus->bank}}</a>
                                    </div>
                            </div>
                        </div>
                            @if($user->bvn == null)
                                <div class="alert alert-warning alert-dismissible alert-alt fade show">
                                    <strong>Warning!</strong> Bvn Not Validate Yet
                                </div>
                            @else
                                <div class="alert alert-success alert-dismissible alert-alt fade show">
                                    <strong>Well-Done!</strong> Bvn Verify
                                </div>
                            @endif
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div class="col-xl-8">
            <div class="card h-auto">
                <div class="card-body">
                    <div class="profile-tab">
                        <div class="custom-tab-1">
                            <ul class="nav nav-tabs">
                                <li class="nav-item"><a href="#my-posts" data-bs-toggle="tab" class="nav-link active show"><i class="fa fa-user-alt"></i> Profile</a>
                                </li>
                                <li class="nav-item"><a href="#about-me" data-bs-toggle="tab" class="nav-link"><i class="fa fa-user-check"></i> Business Profile</a>
                                </li>
                                <li class="nav-item"><a href="#bank" data-bs-toggle="tab" class="nav-link"><i class="fa fa-money-bill"></i>Wallet</a>
                                </li>
                                <li class="nav-item"><a href="#deposit" data-bs-toggle="tab" class="nav-link"><i class="fa fa-money-check"></i>All Deposit</a>
                                </li>
                                <li class="nav-item"><a href="#purchase" data-bs-toggle="tab" class="nav-link"><i class="fa fa-key"></i>All Purchase</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div id="my-posts" class="tab-pane fade active show">
                                    <div class="my-post-content pt-3">
                                        <div class="pt-3">
                                            <div class="settings-form">
                                                <h4 class="text-primary">profile Updating</h4>
                                                <form id="dataForm">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label">Email</label>
                                                            <input type="email" placeholder="Email" name="email" class="form-control" value="{{$user->email}}">
                                                        </div>
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label">Name</label>
                                                            <input type="text" name="name" value="{{$user->name}}" class="form-control"/>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Business Name</label>
                                                        <input type="text" value="{{$user->business_name}}" name="business" class="form-control" readonly/>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Account-Prefix</label>
                                                        <input type="text" value="{{$user->account_prefix}}" name="prefix" class="form-control" required/>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Username</label>
                                                        <input type="text" value="{{$user->username}}" class="form-control" readonly/>
                                                    </div>
                                                    <button class="btn btn-primary" type="submit">Update Now</button>
                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div id="about-me" class="tab-pane fade">
                                    <div class="my-post-content pt-3">
                                        <div class="pt-3">
                                            <div class="settings-form">
                                                <h4 class="text-primary">Business Profile</h4>
                                                <form id="business">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label">Business Email</label>
                                                            <input type="email" placeholder="Email" name="email" class="form-control" value="{{$bus->email}}">
                                                        </div>
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label">Business Phone</label>
                                                            <input type="text" name="phone" value="{{$bus->phone}}" class="form-control"/>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Email Chargeback</label>
                                                        <input type="text" value="{{$bus->cemail}}" name="cemail" class="form-control" />
                                                    </div>
                                                    <button class="btn btn-primary" type="submit">Update Business</button>
                                                </form>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <div id="deposit" class="tab-pane fade">
                                    <div class="card card-body">

                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title">Deposits</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table id="example" class="display min-w850">
                                                            <thead>
                                                            <tr>
                                                                <th>Transaction Id</th>
                                                                <th>Amount</th>
                                                                <th>Date</th>
                                                                <th>Status</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($td as $depo)
                                                                <tr>
                                                                    <td>{{$depo['refid']}}</td>
                                                                    <td>₦{{number_format(intval($depo['amount']*1),2)}}</td>
                                                                    <td>{{$depo['created_at']}}</td>
                                                                    <td>
                                                                        @if($depo['status']=="1")
                                                                            <span class="badge badge-success">success</span>
                                                                        @else
                                                                            <span class="badge badge-warning">pending</span>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                            <tfoot>
                                                            <tr>
                                                                <th>Transaction Id</th>
                                                                <th>Amount</th>
                                                                <th>Date</th>
                                                                <th>Status</th>
                                                            </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <div id="purchase" class="tab-pane fade">
                                    <div class="card card-body">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title">All Bills Transactions</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table id="exampl2" class="display min-w850">
                                                            <thead>
                                                            <tr>
                                                                <th>Date</th>
                                                                <th>Plan</th>
                                                                <th>Amount</th>
                                                                <th>Status</th>
                                                                <th>Response</th>
                                                                <th>Balance Before</th>
                                                                <th>Balance After</th>
                                                                <th>Phone No</th>
                                                                <th>Payment_Ref</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($v as $re)
                                                                <tr>
                                                                    <td>{{$re->timestamp}}</td>
                                                                    <td>{{$re->product}}</td>
                                                                    <td>{{$re->amount}}</td>
                                                                    <td>
                                                                        @if($re->status =="1")
                                                                            <span class="badge badge-success">Deliver Successfully</span>
                                                                        @else
                                                                            <span class="badge badge-danger">Failed(contact Admin)</span>
                                                                        @endif

                                                                    </td>
                                                                    <td ><button class="badge badge-info" onclick="openModal(this)" data-user-id="{{$re->server_response}}">Check Response</button> </td>
                                                                    <td>{{$re->fbalance}}</td>
                                                                    <td>{{$re->balance}}</td>
                                                                    <td>{{$re->number}}</td>
                                                                    <td>{{$re->transactionid}}</td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                            <tfoot>
                                                            <tr>
                                                                <th>Date</th>
                                                                <th>Plan</th>
                                                                <th>Amount</th>
                                                                <th>Status</th>
                                                                {{--                                <th>Response</th>--}}
                                                                <th>Balance Before</th>
                                                                <th>Balance After</th>
                                                                <th>Phone No</th>
                                                                <th>Payment_Ref</th>
                                                            </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                                <style>
                                                    /* Add your CSS styles here */
                                                    .modal {
                                                        display: none;
                                                        position: fixed;
                                                        top: 0;
                                                        left: 0;
                                                        width: 100%;
                                                        height: 100%;
                                                        background-color: rgba(0, 0, 0, 0.5);
                                                    }
                                                    .modal-content {
                                                        background-color: white;
                                                        width: 60%;
                                                        max-width: 400px;
                                                        margin: 100px auto;
                                                        padding: 20px;
                                                        border-radius: 5px;
                                                    }
                                                </style>
                                                <div class="modal" id="editModal">
                                                    <div class="modal-content">
                                                        <div class="card card-body bgl-primary text-primary">
                                                            <div class="media-body">
                                                                <p>Server Response</p>
                                                                <h4  id="id"></h4>
                                                            </div>
                                                        </div>
                                                        <button class="btn btn-outline-danger" onclick="closeModal()">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                </div>
                                <div id="bank" class="tab-pane fade">
                                    <div class="card card-body">
{{--                                        <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6">--}}
                                        <div class="card-bx stacked">
                                            <img src="{{asset('user/images/card/card.png')}}" alt="" class="mw-100">
                                            <div class="card-info text-white">
                                                <p class="mb-1">Wallet Balance</p>
                                                <h2 class="fs-36 text-white mb-sm-4 mb-3">₦{{number_format(intval($user->wallet *1),2)}}</h2>
                                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#fundw">Fund Merchant</button>
                                                <hr>
                                                <p class="mb-1">Wallet Bonus</p>
                                                <h2 class="fs-36 text-white mb-sm-4 mb-3">₦{{number_format(intval($user->bonus *1),2)}}</h2>
                                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#fundc">Credit Bonus</button>

                                                <a href="#"><i class="fa fa-caret-down" aria-hidden="true"></i></a>
                                        </div>
                                        </div>
                                        <div class="">
                                            <div class="card bgl-primary card-body overflow-hidden p-0 d-flex rounded">
                                                <div class="p-0 text-center mt-3">
                                                    <span class="text-black">Total Deposit</span>
                                                    <h3 class="text-black fs-20 mb-0 font-w600">₦{{number_format(intval($sumtt *1),2)}}</h3>
                                                    <br>
                                                    <hr>
                                                    <span class="text-black">Total Purchase</span>
                                                    <h3 class="text-black fs-20 mb-0 font-w600">₦{{number_format(intval($sumbo *1),2)}}</h3>
                                                    <hr>
                                                    <button type="button" class="btn btn-danger">Charge Merchant</button>

                                                    {{--                                                    <span class="text-black"></span>--}}
{{--                                                    <h3 class="text-black fs-20 mb-0 font-w600">₦{{number_format(intval($mcdc *1),2)}}</h3>--}}
                                                </div>
                                                {{--                    <canvas id="lineChart" height="300" class="mt-auto line-chart-demo"></canvas>--}}
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="replyModal">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Post Reply</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <textarea class="form-control" rows="4">Message</textarea>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Reply</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
        <div class="modal fade" id="fundw" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Fund {{$user->username}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="dataForm1">
                            @csrf
                            <div class="row">
                                <div>
                                    <br>
                                    <br>
                                    <div id="AirtimePanel">
                                        <div class="subscribe">
                                            <div id="div_id_network" >
                                                <label for="network" class=" requiredField">
                                                    Enter Amount<span class="asteriskField">*</span>
                                                </label>
                                                <div class="">
                                                    <input type="hidden" name="refid" value="<?php echo rand(100000000000, 9999999999999); ?>">
                                                    <input type="hidden" id="username" name="username"  value="{{$user->username}}" class="text-success form-control" required>
                                                    <input type="number" id="amount" name="amount"  class="text-success form-control" required>
                                                </div>
                                            </div>
                                            <br/>

                                            <button type="submit" class="submit-btn">FUND<span class="load loading"></span></button>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="fundc" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Fund {{$user->username}} Bonus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="bonusForm" >
                            @csrf
                            <div class="row">
                                <div>
                                    <br>
                                    <br>
                                    <div id="AirtimePanel">
                                        <div class="subscribe">
                                            <div id="div_id_network" >
                                                <label for="network" class=" requiredField">
                                                    Enter Amount<span class="asteriskField">*</span>
                                                </label>
                                                <div class="">
                                                    <input type="hidden" id="username1" name="username"  value="{{$user->username}}" class="text-success form-control" required>
                                                    <input type="number" id="amount1" name="amount"  class="text-success form-control" required>
                                                </div>
                                            </div>
                                            <br/>

                                            <button type="submit" class="submit-btn">FUND BONUS<span class="load loading"></span></button>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    <script>
        $(document).ready(function() {
            $('#dataForm1').submit(function(e) {
                e.preventDefault(); // Prevent the form from submitting traditionally
                // Get the form data
                var formData = $(this).serialize();
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to fund ' + document.getElementById("username").value + ' ₦' + document.getElementById("amount").value + '?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // The user clicked "Yes", proceed with the action
                        // Add your jQuery code here
                        // For example, perform an AJAX request or update the page content

                        Swal.fire({
                            title: 'Processing',
                            text: 'Please wait...',
                            icon: 'info',
                            allowOutsideClick: false,
                            showConfirmButton: false
                        });

                        $('#loadingSpinner').show();
                        $.ajax({
                            url: "{{ route('admin/cr') }}",
                            type: 'POST',
                            data: formData,
                            success: function(response) {
                                // Handle the success response here
                                $('#loadingSpinner').hide();

                                console.log(response);
                                // Update the page or perform any other actions based on the response

                                if (response.status == 'success') {
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
                                $('#loadingSpinner').hide();
                                Swal.fire({
                                    icon: 'error',
                                    title: 'fail',
                                    text: xhr.responseText
                                });
                                // Handle any errors
                                console.log(xhr.responseText);

                            }
                        });


                    }
                });


                // Send the AJAX request
            });
        });

    </script>
    <script>
        $(document).ready(function() {
            $('#refundForm').submit(function(e) {
                e.preventDefault(); // Prevent the form from submitting traditionally
                // Get the form data
                var formData = $(this).serialize();
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to re-fund ' + document.getElementById("username1").value + ' ₦' + document.getElementById("amount1").value + '?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // The user clicked "Yes", proceed with the action
                        // Add your jQuery code here
                        // For example, perform an AJAX request or update the page content
                        Swal.fire({
                            title: 'Processing',
                            text: 'Please wait...',
                            icon: 'info',
                            allowOutsideClick: false,
                            showConfirmButton: false
                        });

                        $('#loadingSpinner').show();
                        $.ajax({
                            url: "{{ route('admin/ref') }}",
                            type: 'POST',
                            data: formData,
                            success: function(response) {
                                // Handle the success response here
                                $('#loadingSpinner').hide();

                                console.log(response);
                                // Update the page or perform any other actions based on the response

                                if (response.status == 'success') {
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
                                $('#loadingSpinner').hide();
                                Swal.fire({
                                    icon: 'error',
                                    title: 'fail',
                                    text: xhr.responseText
                                });
                                // Handle any errors
                                console.log(xhr.responseText);

                            }
                        });


                    }
                });


                // Send the AJAX request
            });
        });

    </script>
    <script>
        $(document).ready(function() {
            $('#bonusForm').submit(function(e) {
                e.preventDefault(); // Prevent the form from submitting traditionally
                // Get the form data
                var formData = $(this).serialize();
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to add bonus to ' + document.getElementById("username1").value + ' ₦' + document.getElementById("amount1").value + '?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // The user clicked "Yes", proceed with the action
                        // Add your jQuery code here
                        // For example, perform an AJAX request or update the page content

                        Swal.fire({
                            title: 'Processing',
                            text: 'Please wait...',
                            icon: 'info',
                            allowOutsideClick: false,
                            showConfirmButton: false
                        });

                        $('#loadingSpinner').show();
                        $.ajax({
                            url: "{{ route('admin/bonus') }}",
                            type: 'POST',
                            data: formData,
                            success: function(response) {
                                // Handle the success response here
                                $('#loadingSpinner').hide();

                                console.log(response);
                                // Update the page or perform any other actions based on the response

                                if (response.status == 'success') {
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
                                $('#loadingSpinner').hide();
                                Swal.fire({
                                    icon: 'error',
                                    title: 'fail',
                                    text: xhr.responseText
                                });
                                // Handle any errors
                                console.log(xhr.responseText);

                            }
                        });


                    }
                });


                // Send the AJAX request
            });
        });

    </script>
    <script>
        $(document).ready(function() {
            $('#chargeForm').submit(function(e) {
                e.preventDefault(); // Prevent the form from submitting traditionally
                // Get the form data
                var formData = $(this).serialize();
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to Charge ' + document.getElementById("username3").value + ' ₦' + document.getElementById("amount3").value + '?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Processing',
                            text: 'Please wait...',
                            icon: 'info',
                            allowOutsideClick: false,
                            showConfirmButton: false
                        });
                        // The user clicked "Yes", proceed with the action
                        // Add your jQuery code here
                        // For example, perform an AJAX request or update the page content
                        $('#loadingSpinner').show();
                        $.ajax({
                            url: "{{ route('admin/ch') }}",
                            type: 'POST',
                            data: formData,
                            success: function(response) {
                                // Handle the success response here
                                $('#loadingSpinner').hide();

                                console.log(response);
                                // Update the page or perform any other actions based on the response

                                if (response.status == 'success') {
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
                                $('#loadingSpinner').hide();
                                Swal.fire({
                                    icon: 'error',
                                    title: 'fail',
                                    text: xhr.responseText
                                });
                                // Handle any errors
                                console.log(xhr.responseText);

                            }
                        });


                    }
                });


                // Send the AJAX request
            });
        });

    </script>


    <script>
        function openModal(element) {
            const modal = document.getElementById('editModal');
            const idElement = document.getElementById('id');

            // Assuming you have a data attribute named 'data-user-id' in your HTML
            // Set the text content of the h4 element with the user ID
            idElement.textContent = element.getAttribute('data-user-id');

            modal.style.display = 'block';
            // You can fetch user data using the userId and populate the input fields in the modal if needed
        }

        function closeModal() {
            const modal = document.getElementById('editModal');
            modal.style.display = 'none';
        }

        function saveChanges() {
            // Add code here to save the changes and update the table
            closeModal();
        }
    </script>
@endsection

