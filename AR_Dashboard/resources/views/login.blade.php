@extends('layout.form')

@section('title', 'LogIn')

@section('content')
    <h3 class="mb-2 force-white">Login</h3>
    <small class="force-white">Melden Sie sich mit Ihren Daten ein.</small>
    @if($errors->any())
        <div class="alert alert-danger">{{$errors->first()}}</div>
    @endif

    @if (session('status'))
        <div class="alert alert-success text-center">
            {{ session('status') }}
        </div>
    @endif

    <form action="{{ url('login') }}" method="POST" class="mt-2">
        {{ csrf_field() }}
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fa fa-user"></i></span>
            </div>
            <input type="email" name="email" class="form-control mt-0" placeholder="E-Mail" aria-label="Username" aria-describedby="basic-addon1">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fa fa-lock"></i></span>
            </div>
            <input type="password" name="password" class="form-control mt-0" placeholder="Passwort" aria-label="Password" aria-describedby="basic-addon1">
        </div>

        <div class="form-group">
            <button class="btn btn-light btn-block p-2 mb-1" type="submit" name="submit">Login</button>
            <a href="/forgot-password">
                <small class="force-white"><strong>Passwort vergessen?</strong></small>
            </a>
        </div>
        
    </form>
@endsection