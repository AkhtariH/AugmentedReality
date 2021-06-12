@extends('layout.form')

@section('title', 'Reset password')

@section('content')
    <h3 class="mb-2 force-white">Password reset</h3>
    <small class="force-white">Please reset by typing in your E-Mail and new password</small>
    @if($errors->any())
        <div class="alert alert-danger">{{$errors->first()}}</div>
    @endif

    @if (session('status'))
        <div class="alert alert-success text-center">
            {{ session('status') }}
        </div>
    @endif

    <form action="{{ url('reset-password') }}" method="POST" class="mt-2">
        {{ csrf_field() }}
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fa fa-user"></i></span>
            </div>
            <input type="email" name="email" value="{{ $email }}" class="form-control mt-0" placeholder="E-Mail adress" aria-label="E-Mail" aria-describedby="basic-addon1">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fa fa-lock"></i></span>
            </div>
            <input type="password" name="password" class="form-control mt-0" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fa fa-lock"></i></span>
            </div>
            <input type="password" name="password_confirmation" class="form-control mt-0" placeholder="Password confirmation" aria-label="Password" aria-describedby="basic-addon1">
        </div>

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group">
            <button class="btn btn-light btn-block p-2 mb-1" type="submit" name="submit">Reset</button>
        </div>
        
    </form>
@endsection