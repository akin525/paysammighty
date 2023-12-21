@extends('layouts.sidebar')
@section('tittle', 'MyAccount')
@section('page', 'Profile')
@section('content')
    <div class="row">
        <div class="loading-overlay" id="loadingSpinner" style="display: none;">
        <div class="loading-spinner"></div>
    </div>
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
                                <h4 class="text-primary mb-0">{{Auth::user()->business_name}}</h4>
                                <p>{{Auth::user()->name}}</p>
                            </div>
                            <div class="profile-email px-2 pt-2">
                                <h4 class="text-muted mb-0">{{Auth::user()->email}}</h4>
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
                                <h5 class="text-primary d-inline">Account Status</h5>
                                @if(Auth::user()->account_prefix == null)
                                    <div class="alert alert-warning alert-dismissible alert-alt fade show">
                                        <strong>Warning!</strong> Your profile is not yet complete, kindly complete your profile here
                                    </div>
                                @else
                                    <div class="alert alert-success alert-dismissible alert-alt fade show">
                                        <strong>Well-Done!</strong> Your profile & your business profile is now complete
                                    </div>
                                @endif
                            </div>
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
                                <li class="nav-item"><a href="#bank" data-bs-toggle="tab" class="nav-link"><i class="fa fa-money-bill"></i>Add Bank</a>
                                </li>
                                <li class="nav-item"><a href="#bvn" data-bs-toggle="tab" class="nav-link"><i class="fa fa-money-check"></i>Add BVN</a>
                                </li>
                                <li class="nav-item"><a href="#profile-settings" data-bs-toggle="tab" class="nav-link"><i class="fa fa-key"></i>Transaction Pin</a>
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
                                                            <input type="email" placeholder="Email" name="email" class="form-control" value="{{Auth::user()->email}}">
                                                        </div>
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label">Name</label>
                                                            <input type="text" name="name" value="{{Auth::user()->name}}" class="form-control"/>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Business Name</label>
                                                        <input type="text" value="{{Auth::user()->business_name}}" name="business" class="form-control" readonly/>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Account-Prefix</label>
                                                        <input type="text" value="{{Auth::user()->account_prefix}}" name="prefix" class="form-control" required/>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Username</label>
                                                        <input type="text" value="{{Auth::user()->username}}" class="form-control" readonly/>
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
                                                            <input type="email" placeholder="Email" name="email" class="form-control" value="{{$business->email}}">
                                                        </div>
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label">Business Phone</label>
                                                            <input type="text" name="phone" value="{{$business->phone}}" class="form-control"/>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Email Chargeback</label>
                                                        <input type="text" value="{{$business->cemail}}" name="cemail" class="form-control" />
                                                    </div>
                                                    <button class="btn btn-primary" type="submit">Update Business</button>
                                                </form>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <div id="bvn" class="tab-pane fade">
                                    <div class="my-post-content pt-3">
                                        <div class="pt-3">
                                            <div class="settings-form">
                                                @if(Auth::user()->bvn == null)
                                                <h4 class="text-primary">Add Your Bvn</h4>
                                                <form id="updatebvn" >
                                                    @csrf
                                                    <div class="row">
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label">Validate Your Bvn</label>
                                                            <input type="number"  id="bvn1" name="bvn" minlength="11" maxlength="11" class="form-control"  required>
                                                            <span class="text-info" id="message"></span>
                                                        </div>
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label">Bvn Name</label>
                                                            <input type="text" name="name" class="form-control" readonly/>
                                                        </div>
                                                    </div>

                                                    <button class="btn btn-primary" type="submit">Submit Bvn</button>
                                                </form>
                                                @else
                                                    <h4 class="text-primary">My Bvn</h4>
                                                    <span class="badge badge-success" >{{Auth::user()->bvn}}</span>

                                                @endif
                                            </div>

                                    </div>

                                </div>
                                <div id="profile-settings" class="tab-pane fade">
                                    <div class="card card-body">
                                        <b><h4 class="text-center">Coming Soon</h4> </b>
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
        <script>
            $(document).ready(function () {
                $('#bvn1').on('input', function () {
                    const inputElement = document.getElementById("bvn1");
                    const inputValue = inputElement.value;


                    // Check if inputValue is not undefined and has a length property
                    if (!isNaN(inputValue) && inputValue.length === 11) {
                        $('#loadingSpinner').show();

                        $.ajax({
                            url: '{{ url('bvn') }}/' + inputValue,
                            type: 'GET',
                            success: function (response) {
                                $('#loadingSpinner').hide();
                                $('#name').val(response.data.name);
                                $('#message').val(response.data.message);
                            },
                            error: function (xhr) {
                                $('#loadingSpinner').hide();
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Fail',
                                    text: xhr.responseText
                                });
                                console.log(xhr.responseText);
                            }
                        });
                    }
                });
            });
        </script>




        <script>
        $(document).ready(function() {


            // Send the AJAX request
            $('#dataForm').submit(function(e) {
                e.preventDefault(); // Prevent the form from submitting traditionally

                // Get the form data
                var formData = $(this).serialize();
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

                        $.ajax({
                            url: "{{ route('update') }}",
                            type: 'POST',
                            data: formData,
                            success: function(response) {
                                // Handle the success response here
                                $('#loadingSpinner').hide();

                                console.log(response);
                                // Update the page or perform any other actions based on the response

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


            });
        });

    </script>
    <script>
        $(document).ready(function() {


            // Send the AJAX request
            $('#business').submit(function(e) {
                e.preventDefault(); // Prevent the form from submitting traditionally

                // Get the form data
                var formData = $(this).serialize();
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

                        $.ajax({
                            url: "{{ route('updates') }}",
                            type: 'POST',
                            data: formData,
                            success: function(response) {
                                // Handle the success response here
                                $('#loadingSpinner').hide();

                                console.log(response);
                                // Update the page or perform any other actions based on the response

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


            });
        });

    </script>
    <script>
        $(document).ready(function() {


            // Send the AJAX request
            $('#updatebvn').submit(function(e) {
                e.preventDefault(); // Prevent the form from submitting traditionally

                // Get the form data
                var formData = $(this).serialize();
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

                        $.ajax({
                            url: "{{ route('updatebvn') }}",
                            type: 'POST',
                            data: formData,
                            success: function(response) {
                                // Handle the success response here
                                $('#loadingSpinner').hide();

                                console.log(response);
                                // Update the page or perform any other actions based on the response

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


            });
        });

    </script>

@endsection
