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
                              <h2 class="m-b-0">Sign In</h2>
                          </div>
                          @if ($errors->any())
                              <div class="alert alert-danger mb-5 text-sm text-danger" role="alert">
                                  <div class="font-medium text-red-600">{{ __('Whoops! Something went wrong.') }}</div>
                                  @foreach ($errors->all() as $error)
                                      <div>{{ $error }}</div>
                                  @endforeach
                              </div>
                          @endif

                          @if (session('status'))
                              <div class="mb-4 font-medium text-sm text-green-600">
                                  {{ session('status') }}
                              </div>
                          @endif
                          <form method="POST" action="{{ route('login') }}">
                              @csrf
                              <div class="form-group">
                                  <label class="font-weight-semibold" for="email">{{ __('Email') }}</label>
                                  <div class="input-affix">
                                      <i class="prefix-icon anticon anticon-user"></i>
                                      <input type="email" class="form-control" name="email" id="email" :value="old('email')" placeholder="Username" tabindex="1">
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="font-weight-semibold" for="password">{{ __('Password') }}</label>
                                  @if (Route::has('password.request'))
                                      <a class="float-right font-size-13 text-muted" href="{{ route('password.request') }}">
                                          {{ __('Forget Password?') }}
                                      </a>
                                  @endif
                                  <div class="input-affix m-b-10">
                                      <i class="prefix-icon anticon anticon-lock"></i>
                                      <input type="password" class="form-control" name="password" id="password" placeholder="Password" tabindex="2">
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label for="remember_me">
                                      <input type="checkbox" name="remember" id="remember_me" tabindex="3">
                                      <span class="text-muted">{{ __('Remember me') }}</span>
                                  </label>
                              </div>
                              <div class="form-group">
                                  <div class="d-flex align-items-center justify-content-between">

                                      <span class="font-size-13 text-muted">
                                          Don't have an account?
                                          <a class="" href="{{ route('register')}}"> Signup</a>
                                      </span>

                                      <button type="submit" class="btn btn-primary" tabindex="4">{{ __('Log in') }}</button>
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
