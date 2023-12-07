@extends('layouts.sidebar')
@section('tittle','MyWallet')
@section('page', 'Wallet')
@section('content')

<div class="row">
    <div class="col-xl-6">
        <div class="card text-white bg-success">
            <div class="card-header">
                <h5 class="card-title text-white">Wallet Balance</h5>
            </div>
            <div class="card-body mb-0">
                <h2 class="text-white">₦{{number_format(intval(Auth::user()->wallet *1),2)}}</h2>
                <br>
                <br>
                <h5 class="card-title text-white">Bonus</h5>
                <hr>
                <h2 class="text-white">₦{{number_format(intval(Auth::user()->bonus *1),2)}}</h2>
                <button type="button" onclick="openModal(this)" class="badge badge-danger">Withdraw Bonus</button>
            </div>

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
                    <p>Withdraw To Wallet</p>
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

                                        <button type="submit" class="submit-btn">WITHDRAW<span class="load loading"></span></button>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </form>

                </div>
            </div>
            <button class="btn btn-outline-danger" onclick="closeModal()">Cancel</button>
        </div>
    </div>
    <script>
        function openModal(element) {
            const modal = document.getElementById('editModal');



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
    <div class="col-xl-6">
        <div class="card text-center">
            <div class="card-header">
                <h5 class="card-title">Wallet Account</h5>
            </div>
            <br>
            <br>
            <br>
            <div class="card-body">

                <a href="javascript:void(0);" class="btn btn-success">Generate Account</a>
            </div>

        </div>
    </div>
</div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Wallet Transactions</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="display min-w850">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Source</th>
                                <th>Amount</th>
                                <th>Before Amount</th>
                                <th>After Amount</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($wallet as $depo)
                            <tr>
                                <td>{{$depo['id']}}</td>
                                <td>{{$depo['settlement']}}</td>
                                <td>₦{{number_format(intval($depo['amount']*1),2)}}</td>
                                <td>₦{{number_format(intval($depo['bb']*1),2)}}</td>
                                <td>₦{{number_format(intval($depo['bf']*1),2)}}</td>
                                <td>{{$depo['date']}}</td>
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
                                <th>ID</th>
                                <th>Source</th>
                                <th>Amount</th>
                                <th>Before Amount</th>
                                <th>After Amount</th>
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

@endsection
