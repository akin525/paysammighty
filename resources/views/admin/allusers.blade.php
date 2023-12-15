@extends('admin.layouts.sidebar')
@section('tittle', 'All Merchant')
@section('page', 'All Merchant')
@section('content')
    <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
        <div class="widget-stat card">
            <div class="card-body p-4">
                <div class="media ai-icon">
									<span class="me-3 bgl-primary text-primary">
										<!-- <i class="ti-user"></i> -->
										<svg id="icon-customers" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
											<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
											<circle cx="12" cy="7" r="4"></circle>
										</svg>
									</span>
                    <div class="media-body">
                        <p class="mb-1">All Merchant</p>
                        <h4 class="mb-0">{{number_format(intval($t_users *1))}}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
        <div class="widget-stat card">
            <div class="card-body p-4">
                <div class="media ai-icon">
									<span class="me-3 bgl-primary text-primary">
										<!-- <i class="ti-user"></i> -->
										<svg id="icon-customers" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
											<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
											<circle cx="12" cy="7" r="4"></circle>
										</svg>
									</span>
                    <div class="media-body">
                        <p class="mb-1">Admin</p>
                        <h4 class="mb-0">{{number_format(intval($f_users *1))}}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @foreach($users as $user)
    <div class="col-xl-4 col-lg-12 col-sm-12">
        <div class="card overflow-hidden">
            <div class="text-center p-5 overlay-box" style="background-image: url({{asset('user/images/big/img5.jpg')}});">
                <img src="{{asset('user/images/avatar/1.png')}}" width="100" class="img-fluid rounded-circle" alt="">
                <h3 class="mt-3 mb-0 text-white">{{$user['name']}}</h3>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <div class="bgl-primary rounded p-3">
                            <h4 class="mb-0">Username</h4>
                            <small>{{$user['username']}}</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bgl-primary rounded p-3">
                            <h4 class="mb-0">Business</h4>
                            <small>{{$user['business_name']}}</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer mt-0">
                <a href="{{route('admin/profile', $user['username'])}}" class="btn btn-primary btn-lg btn-block">View Profile</a>
            </div>
        </div>
    </div>
    @endforeach
@endsection
