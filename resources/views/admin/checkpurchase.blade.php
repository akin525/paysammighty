@extends('admin.layouts.sidebar')
@section('tittle', 'Check Transaction')
@section('page', 'Check Transaction')
@section('content')
    @if($purchase !="" || $purchase !=null)
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-0">
            <div class="welcome-text">
                <h3 class="text-black font-w600 mb-0">Transactions Details</h3>
            </div>
            <div class="col-sm-6 p-0 justify-content-sm-start mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
{{--                    <li class="breadcrumb-item active">Transactions</li>--}}
                    <li class="breadcrumb-item"><a href="javascript:void(0)">#{{$purchase->transactionid}}</a></li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-8">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header d-sm-flex d-block border-0 pb-0">
                            <div class="me-auto mb-sm-0 mb-3">
                                <p class="fs-14 mb-1">ID Payment</p>
                                <span class="fs-34 text-black font-w600">#{{$purchase->transactionid}}</span>
                            </div>
                            <div>
                                <a href="javascript:void(0)" class="btn btn-outline-primary btn-rounded me-3 mb-sm-0 mb-2"><i class="las la-file-pdf me-3 scale5"></i>PDF</a>
                                <button id="rever" class="btn btn-primary btn-rounded mb-sm-0 mb-2"><i class="las la-money-bill  me-3"></i>Reverse Invoice</button>
                            </div>
                        </div>
                        <div class="card-body border-bottom">
                            <div class="d-flex flex-wrap mb-sm-2 justify-content-between">
                                <div class="pr-3 mb-3">
                                    <p class="fs-14 mb-1">Payment Method</p>
                                    <span class="text-black fs-18 font-w500">Wallet</span>
                                </div>
                                <div class="pr-3 mb-3">
                                    <p class="fs-14 mb-1">Invoice Date</p>
                                    <span class="text-black fs-18 font-w500">{{$purchase->created_at}}</span>
                                </div>
                                <div class="pr-3 mb-3">
                                    <p class="fs-14 mb-1">Due Date</p>
                                    <span class="text-black fs-18 font-w500">{{$purchase->updated_at}}</span>
                                </div>
                                <div class="mb-3">
                                    <p class="fs-14 mb-1">Date Paid</p>
                                    <span class="text-black fs-18 font-w500">{{$purchase->timestamp}}</span>
                                </div>
                            </div>
                            <div class="card-body p-3 bgl-dark rounded fs-14 d-flex">
{{--                                <svg class="me-3 min-w24" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                    <path d="M12 1C9.82441 1 7.69767 1.64514 5.88873 2.85384C4.07979 4.06253 2.66989 5.7805 1.83733 7.79049C1.00477 9.80047 0.786929 12.0122 1.21137 14.146C1.6358 16.2798 2.68345 18.2398 4.22183 19.7782C5.76021 21.3166 7.72023 22.3642 9.85401 22.7887C11.9878 23.2131 14.1995 22.9953 16.2095 22.1627C18.2195 21.3301 19.9375 19.9202 21.1462 18.1113C22.3549 16.3023 23 14.1756 23 12C22.9966 9.08368 21.8365 6.28778 19.7744 4.22563C17.7122 2.16347 14.9163 1.00344 12 1ZM12 21C10.22 21 8.47992 20.4722 6.99987 19.4832C5.51983 18.4943 4.36628 17.0887 3.68509 15.4442C3.0039 13.7996 2.82567 11.99 3.17294 10.2442C3.5202 8.49836 4.37737 6.89471 5.63604 5.63604C6.89472 4.37737 8.49836 3.5202 10.2442 3.17293C11.99 2.82567 13.7996 3.0039 15.4442 3.68509C17.0887 4.36627 18.4943 5.51983 19.4832 6.99987C20.4722 8.47991 21 10.22 21 12C20.9971 14.3861 20.0479 16.6736 18.3608 18.3608C16.6736 20.048 14.3861 20.9971 12 21Z" fill="#A4A4A4"/>--}}
{{--                                    <path d="M12 9C11.7348 9 11.4804 9.10536 11.2929 9.29289C11.1054 9.48043 11 9.73478 11 10V17C11 17.2652 11.1054 17.5196 11.2929 17.7071C11.4804 17.8946 11.7348 18 12 18C12.2652 18 12.5196 17.8946 12.7071 17.7071C12.8947 17.5196 13 17.2652 13 17V10C13 9.73478 12.8947 9.48043 12.7071 9.29289C12.5196 9.10536 12.2652 9 12 9Z" fill="#A4A4A4"/>--}}
{{--                                    <path d="M12 8C12.5523 8 13 7.55228 13 7C13 6.44771 12.5523 6 12 6C11.4477 6 11 6.44771 11 7C11 7.55228 11.4477 8 12 8Z" fill="#A4A4A4"/>--}}
{{--                                </svg>--}}
                                <p class="">
                                    Being Purchase of {{$purchase->product}} on {{$purchase->number}} initiate on  {{$purchase->timestamp}}, | |
                                    with server response of "{{$purchase->server_response}}" .
                                </p>
                            </div>
                        </div>
                        <div class="card-body">
                            <h4 class="fs-20 text-black font-w600 mb-4">Recipients</h4>
                            <div class="d-sm-flex d-block">
                                <div class="d-flex me-auto mb-sm-0 mb-3 align-items-center">
                                    <img src="{{asset('user/images/avatar/1.png')}}" alt="" class="me-3 rounded-circle" width="85">
                                    <div>
                                        <h3 class="fs-24 text-black font-w600">{{$purchase->username}}</h3>
                                        <span>{{$user->email}}</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center p-3 rounded border border-primary">
                                    <svg class="me-3" width="49" height="49" viewBox="0 0 49 49" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M39.9991 32.4608V36.977C40.0008 37.3962 39.9147 37.8112 39.7464 38.1954C39.5781 38.5795 39.3313 38.9243 39.0217 39.2078C38.7122 39.4912 38.3467 39.707 37.9488 39.8413C37.5508 39.9756 37.1292 40.0255 36.7108 39.9878C32.0692 39.4844 27.6106 37.9015 23.6934 35.3662C20.0488 33.0549 16.9589 29.9711 14.643 26.3338C12.0938 22.4065 10.5074 17.9351 10.0122 13.2819C9.97455 12.8656 10.0241 12.4461 10.1578 12.0499C10.2915 11.6538 10.5063 11.2898 10.7887 10.9811C11.0711 10.6724 11.4148 10.4257 11.7979 10.2569C12.181 10.088 12.5951 10.0005 13.0139 10.0001H17.5391C18.2712 9.99296 18.9808 10.2517 19.5359 10.7281C20.0909 11.2044 20.4534 11.866 20.5559 12.5894C20.7469 14.0347 21.1011 15.4538 21.6118 16.8196C21.8147 17.3584 21.8586 17.944 21.7383 18.507C21.618 19.07 21.3386 19.5867 20.933 19.996L19.0173 21.9079C21.1646 25.6767 24.2914 28.7973 28.0677 30.9403L29.9833 29.0284C30.3935 28.6237 30.9112 28.3448 31.4753 28.2247C32.0394 28.1046 32.6262 28.1485 33.1661 28.351C34.5346 28.8607 35.9565 29.2142 37.4046 29.4048C38.1374 29.508 38.8065 29.8763 39.2849 30.4398C39.7633 31.0032 40.0174 31.7225 39.9991 32.4608Z" fill="#1EAAE7"/>
                                    </svg>
                                    <div>
                                        <p class="text-primary fs-14 mb-1">Telephone</p>
                                        <span class="text-primary font-w600">{{$user->number}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="row">
                <div class="col-xl-12 col-lg-6 col-md-12 mb-5">
                    <div class="card-bx stacked">
                        <img src="{{asset('user/images/card/card.png')}}" alt="" class="mw-100">
                        <div class="card-info text-white">
                            <p class="mb-1">Amount</p>
                            <h2 class="fs-36 text-white mb-sm-4 mb-3">₦{{number_format(intval($purchase->amount *1),2)}}</h2>
                            <hr>
                            <p class="mb-1">PRODUCT NAME</p>
                            <h2 class="fs-36 text-white mb-sm-4 mb-3">{{$purchase->product}}</h2>
                        </div>
                        <a href="#"><i class="fa fa-caret-down" aria-hidden="true"></i></a>
                    </div>

                </div>
                <div class="col-xl-12 col-lg-6 col-md-12">
                    <div class="card">

                        @if($purchase->status =="0")
                            <div class="alert alert-danger alert-dismissible alert-alt fade show">
                                <strong>Ooops!</strong> This transaction was not successful kindly reverse or reprocess this transaction
                            </div>
                        @elseif($purchase->status =="1")
                            <div class="alert alert-success alert-dismissible alert-alt fade show">
                                <strong>Successful!</strong> This transaction was successfully delivered to the customer
                            </div>
                        @endif
                    </div>
                </div>


            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#rever').click(function() {
                // Show the loading spinner
                Swal.fire({
                    title: 'Processing',
                    text: 'Please wait...',
                    icon: 'info',
                    allowOutsideClick: false,
                    showConfirmButton: false
                });

                // Send the selected value to the '/getOptions' route
                $.ajax({
                    url: '{{ route('admin/reverse', $purchase->id) }}',
                    type: 'GET',
                    success: function(response) {
                        // Handle the successful response
                        if (response.status == '1') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message
                            }).then(() => {
                                location.reload(); // Reload the page
                            });
                        } else {
                            Swal.fire({
                                icon: 'info',
                                title: 'Pending',
                                text: response.message
                            });
                            // Handle any other response status
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Fail',
                            text: xhr.responseText
                        });
                        // Handle any errors
                        console.log(xhr.responseText);
                        console.log(xhr);
                    }
                });
            });
        });
    </script>

    @endif

@endsection
