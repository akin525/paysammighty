@extends('layouts.sidebar')
@section('tittle', 'Virtual Accounts')
@section('page', 'Virtual Accounts')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">All Virtual Accounts</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="display min-w850">
                            <thead>
                            <tr>
                                <th>Reference</th>
                                <th>Customer</th>
                                <th>Account.No</th>
                                <th>Provider</th>
                                <th>Currency</th>
                                <th>date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($virtual as $depo)
                                <tr>
                                    <td>{{$depo['refid']}}</td>
                                    <td>{{$depo['account_name']}}</td>
                                    <td>{{$depo['account_name']}}</td>
                                    <td>{{$depo['provider']}}</td>
                                    <td>{{$depo['currency']}}</td>
                                    <td>{{$depo['created_at']}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Reference</th>
                                <th>Customer</th>
                                <th>Account.No</th>
                                <th>Provider</th>
                                <th>Currency</th>
                                <th>date</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
