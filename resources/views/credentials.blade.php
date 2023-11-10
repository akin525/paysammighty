@extends('layouts.sidebar')
@section('tittle', 'API Credentials')
@section('page', 'API Credentials')
@section('content')
    <div class="row">
        <div class="">
            <div class="card h-auto">
                <div class="card-body align-content-center ">
                    <div class="profile-tab">
                        <div class="custom-tab-1">
                            <ul class="nav nav-tabs align-content-center">
                                <li class="nav-item"><a href="#my-posts" data-bs-toggle="tab" class="nav-link active show"><i class="fa fa-key"></i> Apikey</a>
                                </li>
                                <li class="nav-item"><a href="#about-me" data-bs-toggle="tab" class="nav-link"><i class="fa fa-book"></i> Webhook</a>
                                </li>
                                <li class="nav-item"><a href="#profile-settings" data-bs-toggle="tab" class="nav-link"><i class="fa fa-money-bill"></i>Withdraw</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div id="my-posts" class="tab-pane fade active show">
                                    <div class="my-post-content pt-3">
                                        <style>
                                            /* Add some basic styling for the button */
                                            #copyButton {
                                                padding: 10px;
                                                cursor: pointer;
                                            }
                                        </style>

                                        <label>Text Key</label>
                                        <div class="input-group mb-3">
                                            <button class="btn btn-primary" type="button" id="copyButton">Copy</button>
                                            <div class="dropdown bootstrap-select default-select form-control wide">
                                                <input type="text" id="copyText" class="default-select form-control wide" readonly />
                                            </div>
                                        </div>


                                        <label>Live Key</label>
                                        <div class="input-group mb-3">
                                            <button class="btn btn-primary" type="button" id="copyButton1">Copy</button>
                                            <div class="dropdown bootstrap-select default-select form-control wide">
                                                <input type="text" id="copyText1" value="{{Auth::user()->apikey}}"
                                                       class="default-select form-control wide"
                                                       readonly />
                                            </div>
                                        </div>
                                        <script>
                                            document.getElementById('copyButton').addEventListener('click', function() {
                                                // Get the text to copy
                                                var copyText = document.getElementById('copyText');

                                                // Select the text in the input field
                                                copyText.select();
                                                copyText.setSelectionRange(0, 99999); /* For mobile devices */

                                                // Copy the text to the clipboard
                                                document.execCommand('copy');

                                                // Optionally, you can provide some visual feedback to the user
                                                // alert('Text copied to clipboard: ' + copyText.value);
                                            });
                                        </script>
                                        <script>
                                            document.getElementById('copyButton1').addEventListener('click', function() {
                                                // Get the text to copy
                                                var copyText = document.getElementById('copyText1');

                                                // Select the text in the input field
                                                copyText.select();
                                                copyText.setSelectionRange(0, 99999); /* For mobile devices */

                                                // Copy the text to the clipboard
                                                document.execCommand('copy');

                                                // Optionally, you can provide some visual feedback to the user
                                                // alert('Text copied to clipboard: ' + copyText.value);
                                            });
                                        </script>

                                    </div>
                                </div>
                                <div id="about-me" class="tab-pane fade">
                                    <div class="my-post-content pt-3">
                                        <div class="pt-3">
                                            <div class="settings-form">
                                                <h4 class="text-primary">Business WebSite</h4>
                                                <form id="business">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label">Webhook</label>
                                                            <input type="text" name="webhook" value="{{Auth::user()->webhook}}" class="form-control" >
                                                        </div>
                                                    <button class="btn btn-primary" type="submit">Submit</button>
                                                </form>
                                            </div>
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
                    url: "{{ route('updateweb') }}",
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
