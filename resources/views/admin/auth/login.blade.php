<x-guest-layout>
    <div class="col-lg-6 align-self-start">
        <div class="account-info-area" style="background-image: url({{asset('user/images/rainbow.gif')}})">
            <div class="login-content">
                <p class="sub-title">Admin Login-Page</p>
                <h1 class="title">The Evolution of <span>Sammighty</span></h1>
                <p class="text">Instant Bank Transfer Collection</p>

            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-7 col-sm-12 mx-auto align-self-center">
        <div class="login-form">
            <div class="login-head">
                <h3 class="title">Welcome Back</h3>
                <p>SuperAdmin</p>
            </div>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <x-validation-errors class="alert alert-danger" />

            <form method="POST" action="{{ route('admin/log') }}">
                @csrf
                <div class="mb-4">
                    <label class="mb-1 text-black">Email</label>
                    <input type="email" name="email" class="form-control" />
                </div>
                <div class="mb-4">
                    <label class="mb-1 text-black">Password</label>
                    <input type="password" name="password" class="form-control" />
                </div>
                <div class="form-row d-flex justify-content-between mt-4 mb-2">
                    <div class="mb-4">
                        <div class="form-check custom-checkbox mb-3">
                            <input type="checkbox" name="remember" class="form-check-input" id="remember_me" >
                            <label class="form-check-label" for="customCheckBox1">Remember my preference</label>
                        </div>
                    </div>
                </div>
                <div class="text-center mb-4">
                    <button type="submit" class="btn btn-primary btn-block">Sign Me In</button>
                </div>
            </form>
</x-guest-layout>

