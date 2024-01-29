<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Sammighty</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <!-- Favicon icon -->
        <link rel="icon"   href="https://pay.sammighty.com.ng/user/wall.png">
        <link href="{{asset('user/css/style.css')}}" rel="stylesheet">
        <!-- Scripts -->
{{--        @vite(['resources/css/app.css', 'resources/js/app.js'])--}}

        <!-- Styles -->
{{--        @livewireStyles--}}
    </head>
    <body class="h-100">
    <div class="login-account">
        <div class="row h-100">
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
            {{ $slot }}
        </div>
    </div>

        @livewireScripts
    <script src="{{asset('user/vendor/global/global.min.js')}}"></script>
    <script src="{{asset('user/vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
    <script src="{{asset('user/js/custom.min.js')}}"></script>
    <script src="{{asset('user/js/deznav-init.js')}}"></script>
    </body>
</html>
