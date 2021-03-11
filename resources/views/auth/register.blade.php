@extends('layouts/auth')

@section('auth-content')
<div class="container-fluid p-h-0 p-v-20 bg full-height d-flex" style="background-image: url('assets/admin/images/others/login-3.png')">
    <div class="d-flex flex-column justify-content-between w-100">
        <div class="container d-flex h-100">
            <div class="row align-items-center w-100">
                <div class="col-md-7 col-lg-5 m-h-auto">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between m-b-30">
                                <img class="img-fluid" alt="" src="assets/admin/images/logo/logo.png">
                                <h2 class="m-b-0">Sign Up</h2>
                            </div>
                            @if ($errors->any())
                                <div class="alert alert-danger mb-5 text-sm text-danger" role="alert">
                                    <div class="font-medium text-red-600">{{ __('Whoops! Something went wrong.') }}</div>
                                    @foreach ($errors->all() as $error)
                                        <div>{{ $error }}</div>
                                    @endforeach
                                </div>
                            @endif
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="form-group">
                                    <label class="font-weight-semibold" for="name">{{ __('Name') }}</label>
                                    <input type="text" class="form-control" name="name" id="name" :value="old('name')" placeholder="Full Name" required autofocus autocomplete="name">
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-semibold" for="email">{{ __('Email') }}</label>
                                    <input type="email" class="form-control" name="email" id="email" :value="old('email')" placeholder="Email" required>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-semibold" for="password">{{ __('Password') }}</label>
                                    <input type="password" class="form-control" name="password" id="password" required autocomplete="new-password" placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-semibold" for="confirmPassword">{{ __('Confirm Password') }}</label>
                                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password">
                                </div>
                                <div class="form-group">
                                    <div class="d-flex align-items-center justify-content-between p-t-15">
                                        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                                            <div class="checkbox">
                                                <input id="checkbox" type="checkbox" name="terms" id="terms">
                                                <label for="checkbox">
                                                    {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                                            'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms').'</a>',
                                                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy').'</a>',
                                                    ]) !!}
                                                </label>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="d-flex align-items-center justify-content-between p-t-15">
                                        <span class="text-muted"><a href="{{ route('login') }}" class="text-muted">Already registered?</a></span>
                                        <button class="btn btn-primary" type="submit">{{ __('Register') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-none d-md-flex p-h-40 justify-content-between">
            <span class="">© 2019 ThemeNate</span>
            <ul class="list-inline">
                <li class="list-inline-item">
                    <a class="text-dark text-link" href="">Legal</a>
                </li>
                <li class="list-inline-item">
                    <a class="text-dark text-link" href="">Privacy</a>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
