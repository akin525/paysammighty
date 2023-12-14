@extends('admin.layouts.sidebar')
@section('tittle', 'Query Purchase')
@section('page', 'Query Purchase')
@section('content')
    <div class="card">
        <div class="card-body">
            <form class="form-horizontal" method="POST" action="{{ route('admin/datebill') }}">
                @csrf
                <div class="form-group row">
                    <div class="col-md-12">
                        <div class="input-group mt-2">
                            <div class="input-group-prepend">
                                <h3 class="text-success">From: </h3>
{{--                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>--}}
                            </div>
                            <input style="margin-right: 20px" type="date" name="from"  class="form-control @error('from') is-invalid @enderror">

                            <div class="input-group-prepend">
                                <h3 class="text-success">To: </h3>
{{--                                <span class="input-group-text"><i class="fa fa-calendar"></i> </span>--}}
                            </div>
                            <input type="date" name="to"  class="form-control @error('to') is-invalid @enderror">
                        </div>

                        <div class="input-group mt-2" style="align-content: center">
                            <button class="btn btn-primary btn-large" type="submit" style="align-self: center; align-content: center"><i class="fa fa-search"></i> Search</button>
                        </div>
                    </div>
                </div>
                <!--end row-->
            </form>

            <h6 class="text-success">Data Between Selected Dates</h6>
            @if($result ?? '')
                <div>
                    <div class="table-responsive">
                        <table id="example" class="display min-w850">
                        <thead>
                            <th class="table-active"> Username </th>
                            <th>Product</th>
                            <th>Amount</th>
                            <th>Refid</th>
                            <th>Number</th>
                            <th>Balance</th>
                            </thead>
                            <tbody>
                            @foreach($deposit as $row)
                                <tr>
                                    <td>{{$row->username}}</td>
                                    <td>{{$row->product}}</td>
                                    <td>{{$row->amount}}</td>
                                    <td>{{$row->transactionid}}</td>
                                    <td>{{$row->number}}</td>
                                    <td>{{$row->balance}}</td>
                                </tr>
                            @endforeach
                            <br>
                            <center>
                                <button type="button" class="align-content-center btn btn-outline-success text-center">Total =₦{{number_format(intval($sumdate *1),2)}}</button>
                            </center>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection
