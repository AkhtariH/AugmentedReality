@extends('layout.form')

@section('title', 'Log In')
@section('content')
<div class="col-md-6">
    <div class="authincation-content">
        <div class="row no-gutters">
            <div class="col-xl-12">
                <div class="auth-form">
                    <h4 class="text-center mb-4">Sign in your account</h4>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <label class="mb-1"><strong>E-Mail</strong></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="mb-1"><strong>Password</strong></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-row d-flex justify-content-between mt-4 mb-2">
                            <div class="form-group">
                               <div class="custom-control custom-checkbox ml-1">
                                <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="remember">Remember me</label>
                                </div>
                            </div>
                            @if (Route::has('password.request'))
                                <div class="form-group">
                                    <a href="{{ route('password.request') }}">Forgot Password?</a>
                                </div>
                            @endif
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-block">
                                {{ __('Log In') }}
                            </button>

                        </div>
                    </form>
                    <div class="new-account mt-3">
                        <p>Don't have an account? <a class="text-primary" href="{{ route('register') }}">Sign up</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
