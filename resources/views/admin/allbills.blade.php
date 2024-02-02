@extends('admin.layouts.sidebar')
@section('tittle', 'All Purchase')
@section('page', 'All Purchase')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">All Purchase Transactions</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="display min-w850">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Username</th>
                                <th>Plan</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Response</th>
                                <th>Balance Before</th>
                                <th>Balance After</th>
                                <th>Phone No</th>
                                <th>Payment_Ref</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($purchase as $re)
                                <tr>
                                    <td>{{$re->timestamp}}</td>
                                    <td>{{$re->username}}</td>
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
                                    <td>
                                        <a href="{{route('admin/checkid', $re->id)}}" class="badge badge-success">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    </td>
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
                                <th>Action</th>
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
