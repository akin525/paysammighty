@extends('layouts.sidebar')
@section('tittle', 'Airtime')
@section('page', 'Buy Airtime')
@section('content')

    <div style="padding:90px 15px 20px 15px">
        <!--    <h4 class="align-content-center text-center">Data Subscription</h4>-->

        <div class="loading-overlay" id="loadingSpinner" style="display: none;">
            <div class="loading-spinner"></div>
        </div>



        <form id="dataForm" >
            @csrf
            <div class="row">
                <div>
                    <br>
                    <br>
                    <div id="AirtimePanel">
                        <div class="subscribe">
                            <p>AIRTIME PURCHASE</p>
                            {{--                       <input placeholder="Your e-mail" class="subscribe-input" name="email" type="email">--}}
                            <br/>
                            <div id="div_id_network" class="form-group">
                                <label for="network" class=" requiredField">
                                    Network<span class="asteriskField">*</span>
                                </label>
                                <div class="">
                                    <select name="id" class="text-success form-control" required="">

                                        <option value="m">MTN</option>
                                        <option value="g">GLO</option>
                                        <option value="a">AIRTEL</option>
                                        <option value="9">9MOBILE</option>

                                    </select>
                                </div>
                            </div>
                            <br/>
                            <div id="div_id_network" >
                                <label for="network" class=" requiredField">
                                    Enter Amount<span class="asteriskField">*</span>
                                </label>
                                <div class="">
                                    <input type="number" id="amount" name="amount" min="100" max="4000" oninput="calc()" class="text-success form-control" required>
                                </div>
                            </div>
                            <br/>
                            <div id="div_id_network" class="form-group">
                                <label for="network" class=" requiredField">
                                    Enter Phone Number<span class="asteriskField">*</span>
                                </label>
                                <div class="">
                                    <input type="number" id="number" name="number" minlength="11" class="text-success form-control" required>
                                </div>
                            </div>
                            <input type="hidden" name="refid" value="<?php echo rand(10000000, 999999999); ?>">
                            <button type="submit" class="submit-btn">PURCHASE<span class="load loading"></span></button>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="small mb-1" for="amount" style="color: #000000"><b>Amount to Pay (<span>₦</span>)</b></label>
                                    <br>
                                    <span class="text-danger">2% Discount:</span> <b class="text-success">₦<span id="shownow1"></span></b>
                                </div>
                            </div>
                            <script>
                                function calc(){
                                    var value = document.getElementById("amount").value;
                                    var percent = 2/100 * value;
                                    var reducedvalue = value - percent;
                                    document.getElementById("shownow1").innerHTML = reducedvalue;

                                }
                            </script>
                        </div>
                    </div>

                </div>
            </div>

        </form>


    </div>
    <script>
        $(document).ready(function() {


            // Send the AJAX request
            $('#dataForm').submit(function(e) {
                e.preventDefault(); // Prevent the form from submitting traditionally

                // Get the form data
                var formData = $(this).serialize();
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to buy airtime of ₦' + document.getElementById("amount").value + ' on ' + document.getElementById("number").value +' ?',
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

                        $.ajax({
                            url: "{{ route('buyairtime') }}",
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
            });
        });

    </script>

@endsection
