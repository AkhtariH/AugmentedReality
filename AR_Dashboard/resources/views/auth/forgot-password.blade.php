@extends('layout.form')

@section('title', 'Forgot password')

@section('content')
    <h3 class="mb-2 force-white">Forgot password</h3>
    <small class="force-white">Please type in your email address you are registered with.</small>
    @if($errors->any())
        <div class="alert alert-danger">{{$errors->first()}}</div>
    @endif

    @if (session('status'))
        <div class="alert alert-success text-center">
            {{ session('status') }}
        </div>
    @endif

    <form action="{{ url('forgot-password') }}" method="POST" class="mt-2">
        {{ csrf_field() }}
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fa fa-user"></i></span>
            </div>
            <input type="email" name="email" class="form-control mt-0" placeholder="E-Mail adress" aria-label="E-Mail" aria-describedby="basic-addon1">
        </div>

        <div class="form-group">
            <button class="btn btn-light btn-block p-2 mb-1" type="submit" name="submit">Send email</button>
            <a href="/login">
                <small class="force-white"><strong><i class="fas fa-arrow-circle-left"></i> Back to login</strong></small>
            </a>
        </div>
        
    </form>
@endsection