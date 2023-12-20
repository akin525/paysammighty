@extends('layouts.sidebar')
@section('tittle', 'Api Education Transaction')
@section('page', 'Api Education Transaction')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">All Waec pin History</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="display min-w850">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>SERIAL NO</th>
                                <th>PIN</th>
                                <th>REFID</th>
                                <th>date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($waec as $depo)
                                <tr>
                                    <td>{{$depo['id']}}</td>
                                    <td>{{$depo['seria']}}</td>
                                    <td>{{$depo['pin']}}</td>
                                    <td>{{$depo['ref']}}</td>
                                    <td>{{$depo['created_at']}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>SERIAL NO</th>
                                <th>PIN</th>
                                <th>REFID</th>
                                <th>date</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">All Neco pin History</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="display min-w850">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>SERIAL NO</th>
                                <th>PIN</th>
                                <th>REFID</th>
                                <th>date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($neco as $depo)
                                <tr>
                                    <td>{{$depo['id']}}</td>
                                    <td>{{$depo['seria']}}</td>
                                    <td>{{$depo['pin']}}</td>
                                    <td>{{$depo['ref']}}</td>
                                    <td>{{$depo['created_at']}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>SERIAL NO</th>
                                <th>PIN</th>
                                <th>REFID</th>
                                <th>date</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">All Nabteb pin History</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="display min-w850">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>SERIAL NO</th>
                                <th>PIN</th>
                                <th>REFID</th>
                                <th>date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($nabteb as $depo)
                                <tr>
                                    <td>{{$depo['id']}}</td>
                                    <td>{{$depo['seria']}}</td>
                                    <td>{{$depo['pin']}}</td>
                                    <td>{{$depo['ref']}}</td>
                                    <td>{{$depo['created_at']}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>SERIAL NO</th>
                                <th>PIN</th>
                                <th>REFID</th>
                                <th>date</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">All Jamb Pin History</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="display min-w850">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>SERIAL NO</th>
                                <th>PIN</th>
                                <th>RESPONSE</th>
                                <th>date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($nabteb as $depo)
                                <tr>
                                    <td>{{$depo['id']}}</td>
                                    <td>{{$depo['serial']}}</td>
                                    <td>{{$depo['pin']}}</td>
                                    <td>{{$depo['response']}}</td>
                                    <td>{{$depo['created_at']}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>SERIAL NO</th>
                                <th>PIN</th>
                                <th>RESPONSE</th>
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
