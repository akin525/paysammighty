@extends('layouts.sidebar')
@section('tittle', 'Withdraw')
@section('page', 'Withdraw')
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
                            <p>Withdraw From Wallet</p>
                            {{--                       <input placeholder="Your e-mail" class="subscribe-input" name="email" type="email">--}}
                            <br/>
                            <div id="div_id_network" class="form-group">
                                <label for="network" class=" requiredField">
                                    Select Bank<span class="asteriskField">*</span>
                                </label>
                                <div class="">
                                    <select name="id" id="firstSelect" class="text-success form-control" required="">
                                        @foreach($bank as $ba)
                                        <option value="{{$ba['code']}}">{{$ba["name"]}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <br/>
                            <div id="div_id_network" >
                                <label for="network" class=" requiredField">
                                    Enter Account Number<span class="asteriskField">*</span>
                                </label>
                                <div class="">
                                    <input type="number" id="number" name="number"   class="text-success form-control" required>
                                </div>
                            </div>
                            <br/>
                            <div id="div_id_network" class="form-group">
                                <label for="network" class=" requiredField">
                                    Account Name<span class="asteriskField">*</span>
                                </label>
                                <div class="">
                                    <input type="text" id="name" name="name"  class="text-success form-control" required>
                                </div>
                            </div>
                            <br/>
                            <div id="div_id_network" >
                                <label for="network" class=" requiredField">
                                    Enter Amount<span class="asteriskField">*</span>
                                </label>
                                <div class="">
                                    <input type="number" id="amount" name="amount" min="1000"   class="text-success form-control" required>
                                </div>
                            </div>
                            <br/>
                            <input type="hidden" name="refid" value="<?php echo rand(10000000, 999999999); ?>">
                            <button type="submit" class="submit-btn">Withdraw<span class="load loading"></span></button>
{{--                            <div class="col-lg-12">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label class="small mb-1" for="amount" style="color: #000000"><b>Amount to Pay (<span>₦</span>)</b></label>--}}
{{--                                    <br>--}}
{{--                                    <span class="text-danger">2% Discount:</span> <b class="text-success">₦<span id="shownow1"></span></b>--}}
{{--                                </div>--}}
{{--                            </div>--}}
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
            $('#number').on('input', function() {
                var inputElement = document.getElementById("number");
                var inputValue = inputElement.value;
                var secondS = $('#firstSelect');
                var third = $('#name');

                if (inputValue.length === 10 ) {
                    $('#loadingSpinner').show();

                    $.ajax({
                        url: '{{ url('verifyacct') }}/' + inputValue + '/' + secondS.val(),
                        type: 'GET',
                        data: {
                            value1: inputValue,
                            value2: secondS.val()
                        },
                        success: function(response) {
                            $('#loadingSpinner').hide();
                            $('#name').val(response);
                        },
                        error: function(xhr) {
                            $('#loadingSpinner').hide();
                            Swal.fire({
                                icon: 'error',
                                title: 'fail',
                                text: xhr.responseText
                            });
                            console.log(xhr.responseText);
                        }
                    });
                }
            });
        });
    </script>

{{--    <script>--}}
{{--        $(document).ready(function() {--}}


{{--            // Send the AJAX request--}}
{{--            $('#dataForm').submit(function(e) {--}}
{{--                e.preventDefault(); // Prevent the form from submitting traditionally--}}

{{--                // Get the form data--}}
{{--                var formData = $(this).serialize();--}}
{{--                Swal.fire({--}}
{{--                    title: 'Are you sure?',--}}
{{--                    text: 'Do you want to buy airtime of ₦' + document.getElementById("amount").value + ' on ' + document.getElementById("number").value +' ?',--}}
{{--                    icon: 'warning',--}}
{{--                    showCancelButton: true,--}}
{{--                    confirmButtonColor: '#3085d6',--}}
{{--                    cancelButtonColor: '#d33',--}}
{{--                    confirmButtonText: 'Yes',--}}
{{--                    cancelButtonText: 'Cancel'--}}
{{--                }).then((result) => {--}}
{{--                    if (result.isConfirmed) {--}}
{{--                        // The user clicked "Yes", proceed with the action--}}
{{--                        // Add your jQuery code here--}}
{{--                        // For example, perform an AJAX request or update the page content--}}
{{--                        Swal.fire({--}}
{{--                            title: 'Processing',--}}
{{--                            text: 'Please wait...',--}}
{{--                            icon: 'info',--}}
{{--                            allowOutsideClick: false,--}}
{{--                            showConfirmButton: false--}}
{{--                        });--}}

{{--                        $.ajax({--}}
{{--                            url: "{{ route('buyairtime') }}",--}}
{{--                            type: 'POST',--}}
{{--                            data: formData,--}}
{{--                            success: function(response) {--}}
{{--                                // Handle the success response here--}}
{{--                                $('#loadingSpinner').hide();--}}

{{--                                console.log(response);--}}
{{--                                // Update the page or perform any other actions based on the response--}}

{{--                                if (response.status == 'success') {--}}
{{--                                    Swal.fire({--}}
{{--                                        icon: 'success',--}}
{{--                                        title: 'Success',--}}
{{--                                        text: response.message--}}
{{--                                    }).then(() => {--}}
{{--                                        location.reload(); // Reload the page--}}
{{--                                    });--}}
{{--                                } else {--}}
{{--                                    Swal.fire({--}}
{{--                                        icon: 'info',--}}
{{--                                        title: 'Pending',--}}
{{--                                        text: response.message--}}
{{--                                    });--}}
{{--                                    // Handle any other response status--}}
{{--                                }--}}

{{--                            },--}}
{{--                            error: function(xhr) {--}}
{{--                                $('#loadingSpinner').hide();--}}
{{--                                Swal.fire({--}}
{{--                                    icon: 'error',--}}
{{--                                    title: 'fail',--}}
{{--                                    text: xhr.responseText--}}
{{--                                });--}}
{{--                                // Handle any errors--}}
{{--                                console.log(xhr.responseText);--}}

{{--                            }--}}
{{--                        });--}}

{{--                    }--}}
{{--                });--}}
{{--            });--}}
{{--        });--}}

{{--    </script>--}}

@endsection
