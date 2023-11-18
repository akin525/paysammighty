@extends('layouts.sidebar')
@section('tittle', 'BuyDat')
@section('page', 'Buy Data')
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

    <div class="row">
        <!--    <div class="card">-->
        <div class="loading-overlay" id="loadingSpinner" style="display: none;">
            <div class="loading-spinner"></div>
        </div>
        <div class="card-body">
            <div class="module-head">
                <center><h3>
                        Select Network</h3></center>
            </div>
            <center>
                <div class="subscribe btn-controls">
                    <form id="dataForm">
                        @csrf
                        <label for="network" class=" requiredField">
                            Select Your Network<span class="asteriskField">*</span>
                        </label>
                        <select  name="id" id="firstSelect" class="text-success form-control" required="">
                            <option>Select Your Network</option>
                            @if ($serve->name == 'mcd')
                                <option value="mtn-sme data">MTN-SME</option>
                                <option value="mtn-data">MTN-DG</option>
                                <option value="glo-data">GLO</option>
                                <option value="etisalat-data">9MOBILE</option>
                            @elseif($serve->name=='easyaccess')
                                <option value="MTN">MTN</option>
                                <option value="GLO">GLO</option>
                                <option value="9MOBILE">9MOBILE</option>
                                <option value="AIRTEL">AIRTEL</option>
                            @else
                                <option value="MTN">MTN</option>
                                <option value="GLO">GLO</option>
                                <option value="9MOBILE">9MOBILE</option>
                            @endif
                            @if ($serve->name == 'mcd')
                                <option value="airtel-data">AIRTEL</option>
                            @else
                                <option value="AIRTEL_DG">AIRTEL_DG</option>
                                <option value="AIRTEL_CG">AIRTEL_CG</option>
                            @endif
                        </select>

                        <br>
                        <div id="div_id_network" class="form-group">
                            <label for="network" class=" requiredField">
                                Select Your Plan<span class="asteriskField">*</span>
                            </label>
                            <div class="">
                                <select name="productid" id="secondSelect" class="text-success form-control" required>

                                    <option>Select Your Plan</option>
                                </select>
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
                        <button class="submit-btn cta" data-confirm-delete="true" type="submit" >
                            <span class="span">NEXT</span>
                            <span class="second">
      <svg width="50px" height="20px" viewBox="0 0 66 43" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <g id="arrow" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
          <path class="one" d="M40.1543933,3.89485454 L43.9763149,0.139296592 C44.1708311,-0.0518420739 44.4826329,-0.0518571125 44.6771675,0.139262789 L65.6916134,20.7848311 C66.0855801,21.1718824 66.0911863,21.8050225 65.704135,22.1989893 C65.7000188,22.2031791 65.6958657,22.2073326 65.6916762,22.2114492 L44.677098,42.8607841 C44.4825957,43.0519059 44.1708242,43.0519358 43.9762853,42.8608513 L40.1545186,39.1069479 C39.9575152,38.9134427 39.9546793,38.5968729 40.1481845,38.3998695 C40.1502893,38.3977268 40.1524132,38.395603 40.1545562,38.3934985 L56.9937789,21.8567812 C57.1908028,21.6632968 57.193672,21.3467273 57.0001876,21.1497035 C56.9980647,21.1475418 56.9959223,21.1453995 56.9937605,21.1432767 L40.1545208,4.60825197 C39.9574869,4.41477773 39.9546013,4.09820839 40.1480756,3.90117456 C40.1501626,3.89904911 40.1522686,3.89694235 40.1543933,3.89485454 Z" fill="#FFFFFF"></path>
          <path class="two" d="M20.1543933,3.89485454 L23.9763149,0.139296592 C24.1708311,-0.0518420739 24.4826329,-0.0518571125 24.6771675,0.139262789 L45.6916134,20.7848311 C46.0855801,21.1718824 46.0911863,21.8050225 45.704135,22.1989893 C45.7000188,22.2031791 45.6958657,22.2073326 45.6916762,22.2114492 L24.677098,42.8607841 C24.4825957,43.0519059 24.1708242,43.0519358 23.9762853,42.8608513 L20.1545186,39.1069479 C19.9575152,38.9134427 19.9546793,38.5968729 20.1481845,38.3998695 C20.1502893,38.3977268 20.1524132,38.395603 20.1545562,38.3934985 L36.9937789,21.8567812 C37.1908028,21.6632968 37.193672,21.3467273 37.0001876,21.1497035 C36.9980647,21.1475418 36.9959223,21.1453995 36.9937605,21.1432767 L20.1545208,4.60825197 C19.9574869,4.41477773 19.9546013,4.09820839 20.1480756,3.90117456 C20.1501626,3.89904911 20.1522686,3.89694235 20.1543933,3.89485454 Z" fill="#FFFFFF"></path>
          <path class="three" d="M0.154393339,3.89485454 L3.97631488,0.139296592 C4.17083111,-0.0518420739 4.48263286,-0.0518571125 4.67716753,0.139262789 L25.6916134,20.7848311 C26.0855801,21.1718824 26.0911863,21.8050225 25.704135,22.1989893 C25.7000188,22.2031791 25.6958657,22.2073326 25.6916762,22.2114492 L4.67709797,42.8607841 C4.48259567,43.0519059 4.17082418,43.0519358 3.97628526,42.8608513 L0.154518591,39.1069479 C-0.0424848215,38.9134427 -0.0453206733,38.5968729 0.148184538,38.3998695 C0.150289256,38.3977268 0.152413239,38.395603 0.154556228,38.3934985 L16.9937789,21.8567812 C17.1908028,21.6632968 17.193672,21.3467273 17.0001876,21.1497035 C16.9980647,21.1475418 16.9959223,21.1453995 16.9937605,21.1432767 L0.15452076,4.60825197 C-0.0425130651,4.41477773 -0.0453986756,4.09820839 0.148075568,3.90117456 C0.150162624,3.89904911 0.152268631,3.89694235 0.154393339,3.89485454 Z" fill="#FFFFFF"></path>
        </g>
      </svg>
    </span>
                        </button>

                        {{--                    <button type="submit" class=" btn" style="color: white;background-color: #28a745">Click Next<span class="load loading"></span></button>--}}
                    </form>
            </center>
            <br/>
            <br/>
            <style>
                img {
                    max-width: 100%;
                    height: auto;
                }
            </style>
            <div class="card-body">

                <script>
                    const btns = document.querySelectorAll('button');
                    btns.forEach((items)=>{
                        items.addEventListener('click',(evt)=>{
                            evt.target.classList.add('activeLoading');
                        })
                    })
                </script>



                <br>


                <br>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('#firstSelect').change(function() {
                    var selectedValue = $(this).val();
                    // Show the loading spinner
                    $('#loadingSpinner').show();
                    // Send the selected value to the '/getOptions' route
                    $.ajax({
                        url: '{{ url('redata') }}/' + selectedValue,
                        type: 'GET',
                        success: function(response) {
                            // Handle the successful response
                            var secondSelect = $('#secondSelect');
                            $('#loadingSpinner').hide();
                            // Clear the existing options
                            secondSelect.empty();

                            // Append the received options to the second select box
                            $.each(response, function(index, option) {
                                secondSelect.append('<option  value="' + option.id + '">' + option.plan +  ' --₦' + option.tamount + '</option>');
                            });

                            // Select the desired value dynamically
                            var desiredValue = 'value2'; // Set the desired value here
                            secondSelect.val(desiredValue);
                        },
                        error: function(xhr) {
                            // Handle any errors
                            console.log(xhr.responseText);
                        }
                    });
                });
            });

        </script>
        <script>
            $(document).ready(function() {
                $('#dataForm').submit(function(e) {
                    e.preventDefault(); // Prevent the form from submitting traditionally
                    // Get the form data
                    var formData = $(this).serialize();
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'Do you want to buy ' + document.getElementById("secondSelect").options[document.getElementById("secondSelect").selectedIndex].text + ' on ' + document.getElementById("number").value + '?',
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
                                url: "{{ route('bill') }}",
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


@endsection
