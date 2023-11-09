@extends('layouts.sidebar')
@section('tittle', 'Transaction')
@section('page', 'Transaction')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">All Transactions</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="display min-w850">
                        <thead>
                        <tr>
                            <th>Transaction Id</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($alldepo as $depo)
                            <tr>
                                <td>{{$depo['refid']}}</td>
                                <td>₦{{number_format(intval($depo['amount']*1),2)}}</td>
                                <td>{{$depo['created_at']}}</td>
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
                            <th>Transaction Id</th>
                            <th>Amount</th>
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
