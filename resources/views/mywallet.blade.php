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
                <h5 class="card-title text-white">Pending Balance</h5>
                <hr>
                <h2 class="text-white">₦{{number_format(intval($pendingbalance *1),2)}}</h2>
            </div>

        </div>
    </div>
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
