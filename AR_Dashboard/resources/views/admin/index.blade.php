@extends('layout.app')

@section('title', 'Administrator Panel')
@section('subtitle', 'Overview of all users and their art objects.')

@section('content')
@if($errors->any()) 

<div class="alert alert-danger">{{$errors->first()}}</div>
@endif

<div class="row">
    <div class="col-xl-3 col-xxl-3 col-lg-6 col-md-6 col-sm-6">
        <div class="widget-stat card bg-info">
            <div class="card-body p-4">
                <div class="media ai-icon">
                    <span class="mr-3 bgl-primary text-white">
                        <!-- <i class="ti-user"></i> -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-images" viewBox="0 0 16 16">
                            <path d="M4.502 9a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
                            <path d="M14.002 13a2 2 0 0 1-2 2h-10a2 2 0 0 1-2-2V5A2 2 0 0 1 2 3a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v8a2 2 0 0 1-1.998 2zM14 2H4a1 1 0 0 0-1 1h9.002a2 2 0 0 1 2 2v7A1 1 0 0 0 15 11V3a1 1 0 0 0-1-1zM2.002 4a1 1 0 0 0-1 1v8l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71a.5.5 0 0 1 .577-.094l1.777 1.947V5a1 1 0 0 0-1-1h-10z"/>
                          </svg>

                    </span>
                    <div class="media-body text-white">
                        <h3 class="mb-0 text-white"><span class="counter ml-0">{{ count($artObjects) }}</span></h3>
                        <p class="mb-0">Art Objects</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-xxl-3 col-lg-6 col-md-6 col-sm-6">
        <div class="widget-stat card bg-success">
            <div class="card-body p-4">
                <div class="media ai-icon">
                    <span class="mr-3 bgl-primary text-primary" style="color: white !important;">
                        <!-- <i class="ti-user"></i> -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-check2-square" viewBox="0 0 16 16">
                            <path d="M3 14.5A1.5 1.5 0 0 1 1.5 13V3A1.5 1.5 0 0 1 3 1.5h8a.5.5 0 0 1 0 1H3a.5.5 0 0 0-.5.5v10a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V8a.5.5 0 0 1 1 0v5a1.5 1.5 0 0 1-1.5 1.5H3z"/>
                            <path d="m8.354 10.354 7-7a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z"/>
                          </svg>
                    </span>
                    <div class="media-body text-white">
                        <h3 class="mb-0 text-white"><span class="counter ml-0">{{ $approvedCount }}</h3>
                        <p class="mb-0">Approved</p>
                        <small>{{ count($artObjects) > 0 ? round(($approvedCount / count($artObjects)) * 100, 2) : 0 }}%</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-xxl-3 col-lg-6 col-md-6 col-sm-6">
        <div class="widget-stat card bg-warning">
            <div class="card-body p-4">
                <div class="media ai-icon">
                    <span class="mr-3 bgl-primary text-white">
                        <!-- <i class="ti-user"></i> -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-exclamation-square" viewBox="0 0 16 16">
                            <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                            <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                          </svg>
                    </span>
                    <div class="media-body text-white">
                        <h3 class="mb-0 text-white"><span class="counter ml-0">{{ $pendingCount }}</span></h3>
                        <p class="mb-0">Pending</p>
                        <small>{{ count($artObjects) > 0 ? round(($pendingCount / count($artObjects)) * 100, 2) : 0 }}%</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-xxl-3 col-lg-6 col-md-6 col-sm-6">
        <div class="widget-stat card bg-danger">
            <div class="card-body p-4">
                <div class="media ai-icon">
                    <span class="mr-3 bgl-primary text-white">
                        <!-- <i class="ti-user"></i> -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-x-square" viewBox="0 0 16 16">
                            <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                          </svg>
                    </span>
                    <div class="media-body text-white">
                        <h3 class="mb-0 text-white"><span class="counter ml-0">{{ $rejectedCount }}</span></h3>
                        <p class="mb-0">Rejected</p>
                        <small>{{ count($artObjects) > 0 ? round(($rejectedCount / count($artObjects)) * 100, 2) : 0 }}%</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-12 col-xxl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header border-0 pb-0 d-sm-flex d-block">
                <div>
                    <h4 class="card-title mb-1">Pending validation</h4>
                    <small class="mb-0">List of art objects that have to be validated.</small>
                </div>
            </div>
            <div class="card-body orders-summary">
                @if ($pendingCount > 0)
                    <div class="table-responsive">
                        <table class="table table-responsive-md">
                            <thead>
                                <tr>
                                    <th style="width:80px;"><strong>#</strong></th>
                                    <th><strong>ARTIST</strong></th>
                                    <th><strong>NAME</strong></th>
                                    <th><strong>DESCRIPTION</strong></th>
                                    <th><strong>LOCATION</strong></th>
                                    <th><strong>ALTITUDE</strong></th>
                                    <th><strong>DATE</strong></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($artObjects as $object)
                                    @if ($object->status == 'Pending')
                                        <tr>
                                            <td><strong>{{ $object->id }}</strong></td>
                                            <td>{{ $object->username }}</td>
                                            <td>{{ $object->name }}</td>
                                            <td>{{ $object->description }}</td>
                                            <td>{{ $object->latitude }}, {{ $object->longitude }}</td>
                                            <td>{{ $object->floatingHeight }}</td>
                                            <td>{{ $object->created_at->format('d.m.Y') }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('admin.approve', $object->id) }}" class="btn btn-success shadow btn-xs sharp mr-1"><i class="fa fa-check"></i></a>
                                                    <a href="{{ route('admin.reject', $object->id) }}" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-times"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="green" class="bi bi-check-all" viewBox="0 0 16 16">
                            <path d="M8.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L2.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093L8.95 4.992a.252.252 0 0 1 .02-.022zm-.92 5.14.92.92a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 1 0-1.091-1.028L9.477 9.417l-.485-.486-.943 1.179z"/>
                          </svg>
                        <span style="vertical-align: middle;margin-left: 2.5px;">No art objects to review.</span>
                    </p>
                @endif
            </div>
        </div>
    </div>
    <div class="col-xl-12 col-xxl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header border-0 pb-0 d-sm-flex d-block">
                <div>
                    <h4 class="card-title mb-1">Art Objects</h4>
                    <small class="mb-0">Here you can view all art objects.</small>
                </div>
            </div>
            <div class="card-body orders-summary">
                <div class="table-responsive">
                    <table class="table table-responsive-md">
                        <thead>
                            <tr>
                                <th style="width:80px;"><strong>#</strong></th>
                                <th><strong>ARTIST</strong></th>
                                <th><strong>NAME</strong></th>
                                <th><strong>DESCRIPTION</strong></th>
                                <th><strong>LOCATION</strong></th>
                                <th><strong>ALTITUDE</strong></th>
                                <th><strong>DATE</strong></th>
                                <th style="width:100px;"><strong>REVIEW</strong></th>
                                <th><strong>STATUS</strong></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($artObjectsPaginate as $object)
                                <tr>
                                    <td><strong>{{ $object->id }}</strong></td>
                                    <td>{{ $object->username }}</td>
                                    <td>{{ $object->name }}</td>
                                    <td>{{ $object->description }}</td>
                                    <td>{{ $object->latitude }}, {{ $object->longitude }}</td>
                                    <td>{{ $object->floatingHeight }}</td>
                                    <td>{{ $object->created_at->format('d.m.Y') }}</td>
                                    <td><i class="lni lni-star-filled"></i><i class="lni lni-star-filled"></i><i class="lni lni-star-filled"></i><i class="lni lni-star-filled"></i><i class="lni lni-star"></i></td>
                                    <td><span class="badge light {{  $object->status == 'Approved' ? 'badge-success' : ($object->status == 'Rejected' ? 'badge-danger' : 'badge-warning') }}">{{ $object->status }}</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                                <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a href="{{ route('admin.edit', $object->id) }}" class="dropdown-item">
                                                    Edit
                                                </a>
                                                <form action="{{ route('admin.destroy', $object->id) }}" method="post" class="removeForm">
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
                    {!! $artObjectsPaginate->links() !!}
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
    </script>
@endsection