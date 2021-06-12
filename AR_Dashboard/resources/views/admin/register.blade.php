@extends('layout.app')

@section('title', 'Add user')

@section('content')
<div class="mt-1 mb-5 button-container">
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="mb-2">Add user</h3>
            <small class="">Add a new user</small>
            @if($errors->any())
                <div class="alert alert-danger">{{$errors->first()}}</div>
            @endif
            <form action="{{ url('admin/post-register') }}" method="POST" class="mt-2">
                {{ csrf_field() }}
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-user"></i></span>
                    </div>
                    <input type="text" name="name" class="form-control mt-0" placeholder="Full name" aria-label="Full name" aria-describedby="basic-addon1">
                </div>
        
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input type="email" name="email" class="form-control mt-0" placeholder="e-Mail" aria-label="e-Mail" aria-describedby="basic-addon1">
                </div>
        
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-lock"></i></span>
                    </div>
                    <input type="password" name="password" class="form-control mt-0" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1">
                </div>
        
                <div class="input-group mb-3">
                    <select name="type" class="form-control">
                        <option value="customer">Customer</option>
                        <option value="employee">Employee</option>
                        <option value="admin">Administrator</option>
                    </select>
                </div>
        
                <div class="form-group">
                    <button class="btn btn-light btn-block p-2 mb-1" type="submit" name="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection