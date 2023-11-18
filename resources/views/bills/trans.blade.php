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
                                <th>Username</th>
                                <th>Plan</th>
                                <th>Amount</th>
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
                                    <td>{{$re->username}}</td>
                                    <td>{{$re->product}}</td>
                                    <td>{{$re->amount}}</td>
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
                                <th>Username</th>
                                <th>Plan</th>
                                <th>Amount</th>
                                <th>Balance Before</th>
                                <th>Balance After</th>
                                <th>Phone No</th>
                                <th>Payment_Ref</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
