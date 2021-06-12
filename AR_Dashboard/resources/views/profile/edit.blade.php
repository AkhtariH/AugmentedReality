@extends('layout.app')

@section('title', 'Edit profile')

@section('content')
<div class="custom-header">
    <h3>Profil bearbeiten</h3>
</div>
<span class="text-secondary">Dashboard <i class="fa fa-angle-right"></i> Profil <i class="fa fa-angle-right"></i> Bearbeiten</span>
<div class="mt-1 mb-5 button-container" style="margin-top: 20px !important;overflow-x: hidden;">
    <div class="card shadow-sm">
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">{{$errors->first()}}</div>
            @endif

            <div style="max-width: 900px;">
                <form action="{{ route('profile.update', $user->id) }}" method="POST" class="mt-2" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="avatar">
                        <img src="{{ asset('/img/uploads') . '/' . $user->profile_image }}" alt="" class="rounded-circle profile-image" />
                        <div class="form-group" id="imageUpload">
                            <label for="image">{{ $user->name }}</label>
                            <input type="file" class="custom-file-input" style="text-align: left !important;" id="profilePic" name="profile_image">
                            <label class="custom-file-label align-middle" for="profilePic">Choose file</label>
                            <small class="form-text text-muted">Choose a profile picture.</small>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-user"></i></span>
                        </div>
                        <input type="text" name="name" value="{{ $user->username }}" class="form-control mt-0" placeholder="Full name" aria-label="Full name" aria-describedby="basic-addon1">
                    </div>
            
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-envelope"></i></span>
                        </div>
                        <input type="email" name="email" value="{{ $user->email }}" class="form-control mt-0" placeholder="e-Mail" aria-label="e-Mail" aria-describedby="basic-addon1">
                    </div>
            
                    <div class="form-group">
                        <button class="btn btn-light btn-block p-2 mb-1" type="submit" name="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection