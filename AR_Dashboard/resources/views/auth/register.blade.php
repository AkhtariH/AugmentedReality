@extends('layout.form')

@section('content')
<div class="col-md-6">
    <div class="authincation-content">
        <div class="row no-gutters">
            <div class="col-xl-12">
                <div class="auth-form">
                    <h4 class="text-center mb-4">Sign up your account</h4>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group">
                            <label class="mb-1"><strong>Name</strong></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="mb-1"><strong>E-Mail Address</strong></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="mb-1"><strong>Password</strong></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="mb-1"><strong>Confirm Password</strong></label>
                            <input type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                        <div class="text-center">
                            <button type="submit" name="submit" class="btn btn-primary btn-block">
                                {{ __('Sign Up') }}
                            </button>

                        </div>
                    </form>
                    <div class="new-account mt-3">
                        <p>Already have an account? <a class="text-primary" href="{{ route('login') }}">Log In</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
