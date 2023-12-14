@extends('admin.layouts.sidebar')
@section('tittle', 'Paylony Virtual-Account')
@section('page', 'Paylony Virtual-Account')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
            <div class="table-responsive table-hover fs-14 card-table">
                <table id="example" class="display min-w850">
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
                        <th>Reference</th>
                        <th>Date</th>
                        <th>Account Name</th>
                        <th>Account Number</th>
                        <th>Bank Name</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($trans as $deposit)
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
                            <td><span class="text-black font-w500">{{$deposit['reference']}}</span></td>
                            <td><span class="text-black text-nowrap">{{$deposit['created_at']}}</span></td>
                           <td><span class="text-black fs-16 font-w600">{{$deposit['account_name']}}</span></td>
                            <td><span class="text-black fs-16 font-w600">{{$deposit['account_number']}}</span></td>
                            <td><span class="text-black fs-16 font-w600">{{$deposit['provider']}}</span></td>
                            <td><a href="javascript:void(0)" class="btn btn-sm btn-success light">{{$deposit['status']}}</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
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
@endsection
