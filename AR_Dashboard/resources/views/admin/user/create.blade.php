@extends('layout.app')

@section('title', 'Benutzer anlegen')

@section('content')
@if($errors->any())
    <div class="alert alert-danger">{{$errors->first()}}</div>
@endif

<div class="custom-header">
    <h3>Benutzer anlegen</h3>
</div>
<span class="text-secondary">Administrator Panel <i class="fa fa-angle-right"></i> Benutzerverwaltung <i class="fa fa-angle-right"></i> Benutzer anlegen</span>

<div class="mt-1 mb-5 button-container">
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.user.store') }}" method="POST" class="mt-2">
                @csrf
                <div style="max-width: 900px;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-network-wired"></i></span>
                                </div>
                                <input type="text" name="username" class="form-control mt-0" placeholder="Netwerkname" aria-label="Netzwerkname" aria-describedby="basic-addon1">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-user"></i></span>
                                </div>
                                <input type="text" name="first_name" class="form-control mt-0" placeholder="Vorname" aria-label="Vorname" aria-describedby="basic-addon1">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <input type="text" name="last_name" class="form-control mt-0" placeholder="Nachname" aria-label="Nachname" aria-describedby="basic-addon1">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-user"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-envelope"></i></span>
                                </div>
                                <input type="email" name="email" class="form-control mt-0" placeholder="E-Mail Adresse" aria-label="E-Mail Adresse" aria-describedby="basic-addon1">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <select name="type" class="form-control">
                                    <option value="employee">Employee</option>
                                    <option value="admin">Administrator</option>
                                </select>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-user-shield"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <button class="btn btn-primary btn-block p-2 mb-1" type="submit" name="submit">Submit</button>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </form>
        </div>
    </div>
</div>
@endsection