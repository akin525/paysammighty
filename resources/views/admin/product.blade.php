@extends('admin.layouts.sidebar')
@section('tittle', 'Product')
@section('page', 'Easyaccess Product')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive table-hover fs-14 card-table">
                <table class="table display mb-4 dataTablesCard " id="example5">
                    <thead>
                    <tr>
                        <th>
                            <div class="checkbox me-0 align-self-center">
                                <div class="form-check custom-checkbox ">
                                    <input type="checkbox" class="form-check-input" id="checkAll" required="">
                                    <label class="form-check-label" for="checkAll"></label>
                                </div>
                            </div>
                        </th>
                        <th>ID</th>
                        <th>Plan-ID</th>
                        <th>Network</th>
                        <th>Plan</th>
                        <th>Code</th>
                        <th>Amount</th>
                        <th>T-Amount</th>
                        <th>R-Amount</th>
                        <th>Status</th>
                        <th>Server</th>
                        <th>Cat-ID</th>
                        <th>Switch</th>
                        <th>Edit</th>
                    </tr>
                    </thead>
                    <tbody>
                    <link rel="stylesheet" href="{{asset('style.css')}}">
                    <link rel="stylesheet" href="{{asset('demo.css')}}"/>
                    @foreach($product as $deposit)
                        <tr>
                            <td>
                                <div class="checkbox me-0 align-self-center">
                                    <div class="form-check custom-checkbox ">
                                        <input type="checkbox" class="form-check-input" id="customCheckBox2" required="">
                                        <label class="form-check-label" for="customCheckBox2"></label>
                                    </div>
                                </div>
                            </td>
                            <td><span class="text-black font-w500">{{$deposit['id']}}</span></td>
                            <td><span class="text-black font-w500">{{$deposit['plan_id']}}</span></td>
                            <td><span class="text-black text-nowrap">{{$deposit['network']}}</span></td>
                            <td><span class="text-black text-nowrap">{{$deposit['plan']}}</span></td>
                            <td><span class="text-black text-nowrap">{{$deposit['code']}}</span></td>
                            <td><span class="text-black fs-16 font-w600">₦{{number_format(intval($deposit['amount'] *1),2)}}</span></td>
                            <td><span class="text-black fs-16 font-w600">₦{{number_format(intval($deposit['tamount'] *1),2)}}</span></td>
                            <td><span class="text-black fs-16 font-w600">₦{{number_format(intval($deposit['ramount'] *1),2)}}</span></td>
                            <td>
                                @if($deposit['status']=='1')
                                    <a href="javascript:void(0)" class="btn btn-sm btn-success light">Active</a>
                                @else
                                    <a href="javascript:void(0)" class="btn btn-sm btn-warning light">Not Active</a>
                                @endif

                            </td>
                            <td><span class="text-black fs-16 font-w600">{{$deposit['server']}}</span></td>
                            <td><span class="text-black fs-16 font-w600">{{$deposit['cat_id']}}</span></td>
                            <td>
                                <label class="toggleSwitch nolabel">
                                    <input type="checkbox" name="status" value="0" id="myCheckBox"
                                           {{$deposit->status =="1"?'checked':''}}
                                          onclick="window.location='{{route('admin/pd', $deposit->id)}}'"/>
                                    <span>
                                                <span>off</span>
                                                <span>on</span>
                                             </span>

                                    <a></a>
                                </label>
                            </td>
                            <td>
                                <button  type="button" class="btn btn-primary" onclick="openModal(this)" data-user-id="{{$deposit->id}}" data-user-amount="{{$deposit->amount}}" data-user-name="{{$deposit->plan}}" >
                                    <i class="fa fa-edit"></i>Edit
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
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
                    <form id="dataForm" >
                        @csrf
                        <div class="card card-body">
                            <p>EDIT PRODUCT</p>
                            {{--                       <input placeholder="Your e-mail" class="subscribe-input" name="email" type="email">--}}
                            <br/>
                            <div class="form-group">
                                <label>Product-Plan</label>
                                <input type="text" class="form-control" id="plan"  name="name" value="" readonly />
                                <input type="hidden" class="form-control" id="id" name="id" value="" required />
                            </div>
                            <br/>
                            <div id="div_id_network" >
                                <label for="network" class=" requiredField">
                                     Amount<span class="asteriskField">*</span>
                                </label>
                                <div class="">
                                    <input type="number" id="samount" name="amount"  class="text-success form-control" required>
                                </div>
                            </div>
                            <div id="div_id_network" >
                                <label for="network" class=" requiredField">
                                    Enter selling Amount<span class="asteriskField">*</span>
                                </label>
                                <div class="">
                                    <input type="number" id="amount" name="tamount"  class="text-success form-control" required>
                                </div>
                            </div>
                            <br/>
                            <div id="div_id_network" >
                                <label for="network" class=" requiredField">
                                    Enter Reseller Amount<span class="asteriskField">*</span>
                                </label>
                                <div class="">
                                    <input type="number" id="amount" name="ramount"  class="text-success form-control" required>
                                </div>
                            </div>
                            <br/>
                            <button type="submit" class="btn btn-outline-success">Update</button>
                        </div>
                    </form>
                    <button class="btn btn-outline-danger" onclick="closeModal()">Cancel</button>
                </div>
            </div>

        </div>
    </div>
    <script>
        (function($) {
            var table = $('#example5').DataTable({
                searching: false,
                paging:true,
                select: false,
                //info: false,
                lengthChange:false

            });
            $('#example tbody').on('click', 'tr', function () {
                var data = table.row( this ).data();

            });
        })(jQuery);
    </script>
    <script>
        function openModal(element) {
            const modal = document.getElementById('editModal');
            const newNameInput = document.getElementById('id');
            const net = document.getElementById('plan');
            const samount = document.getElementById('samount');
            const userId =element.getAttribute('data-user-id');
            const amount =element.getAttribute('data-user-amount');
            const userName = element.getAttribute('data-user-name');



            newNameInput.value = userId;
            net.value = userName;
            samount.value=amount;

            console.log(newNameInput);
            console.log(net);
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
                $('#loadingSpinner').show();

                $.ajax({
                    url: "{{route('admin/do')}}",
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
            });
        });

    </script>

@endsection
