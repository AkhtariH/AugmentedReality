@extends('layout.app')

@section('title', $user->name)
@section('subtitle', 'Dashboard > Profile')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="profile card card-body px-3 pt-3 pb-0">
                <div class="profile-head">
                    <div class="photo-content">
                        <div class="cover-photo">
                            <img src="{{ asset('img/banner.jpg') }}" alt="" style="width: 100%; height: 300px;object-fit: cover;"/>
                        </div>
                    </div>
                    <div class="profile-info">
                        <div class="profile-photo">
                            <img src="{{ asset('img/uploads/' . $user->profile_image) }}" style="object-fit: cover;width: 100px;height: 100px;border-radius: 100px;box-shadow: 0 0 0 4px #fff;" class="img-fluid rounded-circle" alt="">
                        </div>
                        <div class="profile-details">
                            <div class="profile-name px-3 pt-2">
                                <h4 class="text-primary mb-0">{{ $user->name }}</h4>
                                <p>{{ ucfirst($user->type) }}</p>
                            </div>
                            <div class="profile-email px-2 pt-2">
                                <h4 class="text-muted mb-0">{{ $user->email }}</h4>
                                <p>Email</p>
                            </div>
                            {{-- <div class="dropdown ml-auto">
                                <a href="#" class="btn btn-primary light sharp" data-toggle="dropdown" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg></a>
                                <ul class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(40px, 40px, 0px);">
                                    <li class="dropdown-item"><i class="fa fa-user-circle text-primary mr-2"></i> View profile</li>
                                    <li class="dropdown-item"><i class="fa fa-users text-primary mr-2"></i> Add to close friends</li>
                                    <li class="dropdown-item"><i class="fa fa-plus text-primary mr-2"></i> Add to group</li>
                                    <li class="dropdown-item"><i class="fa fa-ban text-primary mr-2"></i> Block</li>
                                </ul>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="profile-statistics mb-5">
                        <div class="text-center">
                            <div class="row">
                                <div class="col">
                                    <h3 class="m-b-0">{{ $approvedCount }}</h3><span>Approved</span>
                                </div>
                                <div class="col">
                                    <h3 class="m-b-0">{{ $pendingCount }}</h3><span>Pending</span>
                                </div>
                                <div class="col">
                                    <h3 class="m-b-0">{{ $rejectedCount }}</h3><span>Rejected</span>
                                </div>
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('home.index') }}" class="btn btn-primary mb-1 mr-1">Upload Art</a> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <div class="profile-tab">
                        <div class="custom-tab-1">
                            <ul class="nav nav-tabs">
                                <li class="nav-item"><a href="#my-art" data-toggle="tab" class="nav-link show active">Art Objects</a>
                                </li>
                                <li class="nav-item"><a href="#profile-settings" data-toggle="tab" class="nav-link">Setting</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div id="my-art" class="tab-pane fade active show">
                                    <div class="my-post-content pt-3">
                                        <div class="table-responsive">
                                            <table class="table table-responsive-md">
                                                <thead>
                                                    <tr>
                                                        <th style="width:80px;"><strong>#</strong></th>
                                                        <th><strong>NAME</strong></th>
                                                        <th><strong>DESCRIPTION</strong></th>
                                                        <th><strong>DATE</strong></th>
                                                        <th><strong>REVIEW</strong></th>
                                                        <th><strong>STATUS</strong></th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($artObjects as $key=>$object)
                                                        <tr>
                                                            <td><strong>{{ ++$key }}</strong></td>
                                                            <td>{{ $object->name }}</td>
                                                            <td>{{ $object->description }}</td>
                                                            <td>{{ $object->created_at->format('d.m.Y') }}</td>
                                                            <td><i class="lni lni-star-filled"></i><i class="lni lni-star-filled"></i><i class="lni lni-star-filled"></i><i class="lni lni-star-filled"></i><i class="lni lni-star"></i></td>
                                                            <td><span class="badge light {{  $object->status == 'Approved' ? 'badge-success' : ($object->status == 'Rejected' ? 'badge-danger' : 'badge-warning') }}">{{ $object->status }}</span></td>
                                                            <td>
                                                                <div class="dropdown">
                                                                    <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                                                        <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                                                                    </button>
                                                                    <div class="dropdown-menu">
                                                                        <a href="{{ route('home.edit', $object->id) }}" class="dropdown-item">
                                                                            Edit
                                                                        </a>
                                                                        <form action="{{ route('home.destroy', $object->id) }}" method="post" class="removeForm">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="dropdown-item" onclick="return confirm('Are you sure?')">
                                                                                Delete
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row" style="justify-content: center !important;margin-top:10px;">
                                            {!! $artObjects->links() !!}
                                        </div>
                                    </div>
                                </div>
                                <div id="profile-settings" class="tab-pane fade">
                                    <div class="pt-3">
                                        <div class="settings-form">
                                            <h4 class="text-primary">Account Setting</h4>
                                            <form action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label>Name</label>
                                                        <input type="text" name="name" placeholder="Name" value="{{ $user->name }}" class="form-control">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>E-Mail Adress</label>
                                                        <input type="email" name="email" value="{{ $user->email }}" placeholder="E-Mail Adress" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Profile Picture</label>
                                                    <div class="custom-file">
                                                        <input type="file" id="file" name="profile_image" class="custom-file-input">
                                                        <label class="custom-file-label">Choose file</label>
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary" type="submit">Update</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    var errorMsg = '{{ $errors->first() }}';
    if (errorMsg != '' && errorMsg != null) {
        toastr.error(errorMsg, "Error", {
            timeOut: 20000,
            closeButton: !0,
            debug: !1,
            newestOnTop: !0,
            progressBar: !0,
            positionClass: "toast-top-right",
            preventDuplicates: !0,
            onclick: null,
            showDuration: "300",
            hideDuration: "1000",
            extendedTimeOut: "1000",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut",
            tapToDismiss: !1
        }).css({
            "width": "500px",
            "max-width": "500px",
            "font-size": "20px"
        });
    }

    var successMsg = '{{ session("success") }}';
    if (successMsg != '' && successMsg != null) {
        toastr.success(successMsg, "Success", {
            timeOut: 10000,
            closeButton: !0,
            debug: !1,
            newestOnTop: !0,
            progressBar: !0,
            positionClass: "toast-top-right",
            preventDuplicates: !0,
            onclick: null,
            showDuration: "300",
            hideDuration: "1000",
            extendedTimeOut: "1000",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut",
            tapToDismiss: !1
        }).css({
            "width": "500px",
            "max-width": "500px",
            "font-size": "20px"
        });
    }

    document.getElementById('file').onchange = function () {
        $('.custom-file-label').html(this.value);
    };
</script>
@endsection