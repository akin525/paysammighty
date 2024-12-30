<x-guest-layout>
    <div class="col-lg-6 align-self-start">
        <div class="account-info-area" style="background-image: url({{asset('user/images/rainbow.gif')}})">
            <div class="login-content">
                <p class="sub-title">Enter Verification Code</p>
                <h1 class="title">The Evolution of <span>Sammighty</span></h1>
                <p class="text">Instant Bank Transfer Collection</p>

            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-7 col-sm-12 mx-auto align-self-center">
        <div class="login-form">
            <div class="login-head">
                <h3 class="title">Welcome Back</h3>
                <p>Sell online, process payments whether online or not. Simply
                    complete payment on the go using your banking app or ussd.</p>
            </div>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <x-validation-errors class="alert alert-danger" />

            <form method="POST" action="{{ url('2fa') }}">
                @csrf
                <div class="mb-4">
                    <label class="mb-1 text-black">Enter Verification Code</label>
                    <input type="text" name="code" id="code" class="form-control" />
                </div>

                <div class="text-center mb-4">
                    <button type="submit" class="btn btn-primary btn-block">Verify</button>
                </div>
            </form>
</x-guest-layout>
