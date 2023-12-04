@extends('layouts.sidebar')
@section('tittle', 'Bills Transaction')
@section('page', 'Bills Transaction')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">All Bills Transactions</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="display min-w850">
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
                            @foreach($bill as $re)
                                <tr>
                                    <td>{{$re->timestamp}}</td>
                                    <td>{{$re->product}}</td>
                                    <td>{{$re->amount}}</td>
                                    <td>
                                        @if($re->status =="1")
                                            <span class="badge badge-success">Deliver Successfully</span>
                                        @else
                                            <span class="badge badge-success">Failed(contact Admin)</span>
                                        @endif

                                    </td>
                                    <td ><button class="badge badge-danger" onclick="openModal(this)" data-user-id="{{$re->server_response}}">Check Response</button> </td>
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
                                <th>Response</th>
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
                            @csrf
                            <div class="card card-body bg-success">
                                <p>Server Response</p>
                                <h6 id="id"></h6>
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
            const newNameInput = document.getElementById('id');
            const net = document.getElementById('plan');
            const userId =element.getAttribute('data-user-id');
            const userName = element.getAttribute('data-user-name');



            newNameInput.value = userId;
            net.value = userName;

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

@endsection
