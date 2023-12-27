00000000000000000000000000000<head>
    <!-- All Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="DexignZone">
    <meta name="robots" content="index, follow">
    <meta name="keywords" content="admin, admin dashboard, admin template, analytics, bootstrap, bootstrap 5, modern, responsive admin dashboard, sales dashboard, sass, ui kit, web app">
    <meta name="description" content="Looking for a sleek and modern dashboard website template for a payment management system? Our template is perfect for digital payments, transaction history, and more. Elevate your admin dashboard with stunning visuals and user-friendly functionality. Try it out today!">
    <meta property="og:title" content="SAMMIGHTY: Payment Platform">
    <meta property="og:description" content="Looking for a sleek and modern dashboard website template for a payment management system? Our template is perfect for digital payments, transaction history, and more. Elevate your admin dashboard with stunning visuals and user-friendly functionality. Try it out today!">
    <meta property="og:image" content="social-image.png">
    <meta name="format-detection" content="telephone=no">

    <!-- Mobile Specific -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Title -->
    <title>@yield('tittle')</title>

    <!-- Favicon icon -->
    <link rel="icon" sizes="16x16" href="{{asset('user/wall.png')}}">

    <link href="{{asset('user/vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet')}}">
    <link rel="stylesheet" href="{{asset('user/vendor/chartist/css/chartist.min.css')}}">
    <link href="{{asset('user/vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet">
    <link href="{{asset('user/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('user/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{asset('user/vendor/lightgallery/css/lightgallery.min.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">

    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @yield('style')

</head>
<body>
<style>
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .loading-spinner {
        width: 40px;
        height: 40px;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #3498db;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<!--*******************
    Preloader start
********************-->
<div id="preloader">
    <div class="sk-three-bounce">
        <div class="sk-child sk-bounce1"></div>
        <div class="sk-child sk-bounce2"></div>
        <div class="sk-child sk-bounce3"></div>
    </div>
</div>
<!--*******************
    Preloader end
********************-->

<!--**********************************
    Main wrapper start
***********************************-->
<div id="main-wrapper">

    @if(Session::has('error'))
        <script>
            Swal.fire({
                title: 'Ooops..',
                text: '{{ Session::get('error') }}',
                icon: 'warning',
                confirmButtonColor: '#3085d6',
            })
        </script>
@endif
<!--**********************************
        Nav header start
    ***********************************-->
    <div class="nav-header">
        <a href="#" class="brand-logo">
            <img class="logo-abbr" src="{{asset('user/wallet.png')}}" alt="">
            <img class="logo-compact" src="{{asset('user/sa.png')}}" alt="">
            <img class="brand-title" src="{{asset('user/sa1.png')}}" alt="">
        </a>

        <div class="nav-control">
            <div class="hamburger">
                <span class="line"></span><span class="line"></span><span class="line"></span>
            </div>
        </div>
    </div>
    <!--**********************************
        Nav header end
    ***********************************-->


    <!--**********************************
        Header start
    ***********************************-->
    <div class="header">
        <div class="header-content">
            <nav class="navbar navbar-expand">
                <div class="collapse navbar-collapse justify-content-between">
                    <div class="header-left">
                        <div class="dashboard_bar">
                            <div class="input-group search-area d-lg-inline-flex d-none">
                                <div class="input-group-append">
                                    <button class="input-group-text search_icon search_icon"><i class="flaticon-381-search-2"></i></button>
                                </div>
                                <input type="text" class="form-control" placeholder="Search here...">
                            </div>
                        </div>
                    </div>
                    <ul class="navbar-nav header-right">
                        <li class="nav-item">
                            <div class="d-flex weather-detail">
                                <span><i class="las la-cloud"></i>21</span>
                                Medan, IDN
                            </div>
                        </li>
                        <li class="nav-item dropdown notification_dropdown">
                            <a class="nav-link bell dz-theme-mode" href="javascript:void(0);">
                                <i id="icon-light" class="fas fa-sun"></i>
                                <i id="icon-dark" class="fas fa-moon"></i>

                            </a>
                        </li>
                        <li class="nav-item dropdown notification_dropdown">
                            <a class="nav-link  ai-icon" href="javascript:void(0)" role="button" data-bs-toggle="dropdown">
                                <svg width="20" height="20" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12.6001 4.3008V1.4C12.6001 0.627199 13.2273 0 14.0001 0C14.7715 0 15.4001 0.627199 15.4001 1.4V4.3008C17.4805 4.6004 19.4251 5.56639 20.9287 7.06999C22.7669 8.90819 23.8001 11.4016 23.8001 14V19.2696L24.9327 21.5348C25.4745 22.6198 25.4171 23.9078 24.7787 24.9396C24.1417 25.9714 23.0147 26.6 21.8023 26.6H15.4001C15.4001 27.3728 14.7715 28 14.0001 28C13.2273 28 12.6001 27.3728 12.6001 26.6H6.19791C4.98411 26.6 3.85714 25.9714 3.22014 24.9396C2.58174 23.9078 2.52433 22.6198 3.06753 21.5348L4.20011 19.2696V14C4.20011 11.4016 5.23194 8.90819 7.07013 7.06999C8.57513 5.56639 10.5183 4.6004 12.6001 4.3008ZM14.0001 6.99998C12.1423 6.99998 10.3629 7.73779 9.04973 9.05099C7.73653 10.3628 7.00011 12.1436 7.00011 14V19.6C7.00011 19.817 6.94833 20.0312 6.85173 20.2258C6.85173 20.2258 6.22871 21.4718 5.57072 22.7864C5.46292 23.0034 5.47412 23.2624 5.60152 23.4682C5.72892 23.674 5.95431 23.8 6.19791 23.8H21.8023C22.0445 23.8 22.2699 23.674 22.3973 23.4682C22.5247 23.2624 22.5359 23.0034 22.4281 22.7864C21.7701 21.4718 21.1471 20.2258 21.1471 20.2258C21.0505 20.0312 21.0001 19.817 21.0001 19.6V14C21.0001 12.1436 20.2623 10.3628 18.9491 9.05099C17.6359 7.73779 15.8565 6.99998 14.0001 6.99998Z" fill="#3E4954"/>
                                </svg>
                                <span class="badge light text-white bg-primary rounded-circle">12</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <div id="DZ_W_Notification1" class="widget-media dz-scroll p-3 height380">
                                    <ul class="timeline">

                                        <li>
                                            <div class="timeline-panel">
                                                <div class="media me-2 media-success">
                                                    <i class="fa fa-home"></i>
                                                </div>
                                                <div class="media-body">
                                                    <h6 class="mb-1">Add New Business</h6>
                                                    <small class="d-block">Click here</small>
                                                </div>
                                            </div>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown header-profile">
                            <a class="nav-link" href="javascript:void(0)" role="button" data-bs-toggle="dropdown">
                                <div class="header-info">
                                    <span class="text-black">Hello,<strong>{{Auth::user()->username}}</strong></span>
                                    <p class="fs-12 mb-0">{{Auth::user()->name}}</p>
                                </div>
                                <img src="{{asset('user/sam3.png')}}" width="20" alt="">
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="{{route('myaccount')}}" class="dropdown-item ai-icon">
                                    <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    <span class="ms-2">Profile </span>
                                </a>
                                <a href="#" class="dropdown-item ai-icon">
                                    <svg id="icon-inbox" xmlns="http://www.w3.org/2000/svg" class="text-success" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                    <span class="ms-2">Inbox </span>
                                </a>
                                <a href="{{route('logout')}}" class="dropdown-item ai-icon">
                                    <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                    <span class="ms-2">Logout </span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
    <!--**********************************
        Header end ti-comment-alt
    ***********************************-->
    <!--**********************************
             Sidebar start
         ***********************************-->
    <div class="deznav">
        <div class="deznav-scroll">
            <ul class="metismenu" id="menu">
                <li><a  href="{{route('admin/dashboard')}}">
                        <i class="flaticon-381-networking"></i>
                        <span class="nav-text">Dashboard</span>
                        <span class="badge badge-xs style-1 badge-danger">HOT</span>

                    </a>
                </li>
                <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="flaticon-381-network"></i>
                        <span class="nav-text">Server Switch</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="#">Data Server</a></li>
                        <li><a href="#">Airtime Server</a></li>
                    </ul>
                </li>
                <li><a  href="{{route('admin/deposits')}}">
                        <i class="fa fa-wallet"></i>
                        <span class="nav-text">Deposits</span>
                        <span class="badge badge-xs style-1 badge-success">₦</span>

                    </a>
                </li>
                <li><a  href="{{route('admin/allbills')}}">
                        <i class="fa fa-cart-plus"></i>
                        <span class="nav-text">All Purchase</span>
{{--                        <span class="badge badge-xs style-1 badge-success">₦</span>--}}

                    </a>
                </li>
                <li><a  href="{{route('admin/alltransfer')}}">
                        <i class="fa fa-network-wired"></i>
                        <span class="nav-text">My Transfer</span>
                    </a>
                </li>
                <li><a  href="{{route('admin/message')}}">
                        <i class="fa fa-envelope-open-text"></i>
                        <span class="nav-text">Post Message</span>
                        <span class="badge badge-xs style-1 badge-danger">HOT</span>

                    </a>
                </li>
                <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="flaticon-381-user-2"></i>
                        <span class="nav-text">Virtual Account</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{route('admin/allvirtual')}}">Sammighty</a></li>
                        <li><a href="{{route('admin/payvirtual')}}">Paylony</a></li>
                    </ul>
                </li>
                <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="fa-regular fa-gear fw-bold"></i>
                        <span class="nav-text">Fetch Trans</span>
{{--                        <span class="badge badge-xs style-1 badge-danger">New</span>--}}
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{route('admin/depositquery')}}">Collection</a></li>
                        <li><a href="{{route('admin/billquery')}}">Purchase</a></li>
                    </ul>
                </li>
                <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="flaticon-381-controls-3"></i>
                        <span class="nav-text">Report</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{url('admin/report_daily')}}">Daily</a></li>
                        <li><a href="{{url('admin/report_monthly')}}">Monthly</a></li>
                        <li><a href="#">Yearly</a></li>
                    </ul>
                </li>
                <li><a  href="{{route('admin/alluser')}}">
                        <i class="fa fa-users"></i>
                        <span class="nav-text">All Merchant</span>
                    </a>
                </li>
            </ul>

            <div class="copyright">
                <p><strong>Sammighty Instant Bank Transfer Collection</strong> </p>
            </div>
        </div>
    </div>
    <!--**********************************
        Sidebar end
    ***********************************-->

    <!--**********************************
        Content body start
    ***********************************-->
    <div class="content-body">
        <!-- row -->
        <div class="container-fluid">
            <div class="form-head mb-4">
                @if(Auth::user()->account_prefix == null)
                    <div class="alert alert-warning alert-dismissible alert-alt fade show">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                        </button>
                        <strong>Warning!</strong> Please Kindly Update your account to verify your business
                        <a href="{{route('myaccount')}}" class="badge badge-success">Update Here</a>
                    </div>
                @endif
                <h2 class="text-black font-w600 mb-0">@yield('page')</h2>
            </div>
            <div class="row">
                @yield('content')
            </div>
        </div>
    </div>
    <div class="footer">
        <div class="copyright">
            <p>Copyright © Designed &amp; Developed by <a href="#" target="_blank">Sammighty</a> 2023</p>
        </div>
    </div>
</div>
@yield('script')
<script src="{{asset('user/vendor/global/global.min.js')}}"></script>
<script src="{{asset('user/vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
<script src="{{asset('user/vendor/chart-js/chart.bundle.min.js')}}"></script>

<script src="{{asset('user/js/custom.min.js')}}"></script>
<script src="{{asset('user/js/deznav-init.js')}}"></script>
<script src="{{asset('user/js/demo.js')}}"></script>
<script src="{{asset('user/js/styleSwitcher.js')}}"></script>

<script src="{{asset('user/vendor/ckeditor/ckeditor.js')}}"></script>

<!-- Chart piety plugin files -->
<script src="{{asset('user/vendor/peity/jquery.peity.min.js')}}"></script>

<!-- Apex Chart -->
<script src="{{asset('user/vendor/apexchart/apexchart.js')}}"></script>

<!-- Dashboard 1 -->
<script src="{{asset('user/js/dashboard/my-wallet.js')}}"></script>
<!-- Datatable -->
<script src="{{asset('user/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('user/js/plugins-init/datatables.init.js')}}"></script>
</body>
