@extends('layout.app')

@section('title', 'Benutzerverwaltung')

@section('content')
    @if (session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    <div class="custom-header">
        <h3>Benutzer <a href="{{ route('admin.user.create') }}" class="badge badge-success" style="font-size: 12px;"><i class="fa fa-plus"></i> Neuer Benutzer</a></h3>
    </div>
    <span class="text-secondary">Administrator Panel <i class="fa fa-angle-right"></i> Benutzerverwaltung</span>

    <h5 style="margin-top: 20px">Mitarbeiter</h5>
    <div class="row pl-0">
        @if (!$employees->isEmpty())
            @foreach ($employees as $employee)
                <div class="col-lg-4 col-md-4 col-sm-4 col-12 mb-3 user-card">
                    <div class="bg-white border shadow">
                        <div class="media p-4">
                            <div class="align-self-center mr-3 rounded-circle notify-icon bg-theme">
                                <img src="{{ asset('/img/uploads') . '/' .$employee->profile_image }}" alt="profilePic" class="rounded-circle" width="50" height="50">
                            </div>
                            <div class="media-body pl-2">
                                <h5 class="mt-0 mb-0"><strong><a href="{{ route('admin.user.show', $employee->id) }}" class="bootstrap-link">{{ $employee->first_name }} {{ $employee->last_name }} ({{ $employee->username }})</a></strong></h5>
                                <p><small class="text-muted bc-description">{{ ucfirst($employee->type) }}</small></p>
                                <p><small class="text-muted bc-description">{{ $employee->email }}</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-lg-4 col-md-4 col-sm-4 col-12 mb-3 user-card">
                <p>Keine Mitarbeiter gefunden!</p>
            </div>
        @endif
    </div>

    <h5 style="margin-top: 15px">Administratoren</h5>
    <div class="row pl-0">
        @if (!$admins->isEmpty())
            @foreach ($admins as $admin)
                <div class="col-lg-4 col-md-4 col-sm-4 col-12 mb-3 user-card">
                    @if ($admin->id != Auth()->user()->id)
                        <form action="{{ route('admin.user.destroy', $admin->id) }}" method="post" class="removeForm">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="deleteButton close" onclick="return confirm('Are you sure?')">
                                <i class="far fa-times-circle"></i>
                            </button>
                        </form>
                    @endif
                    <div class="bg-white border shadow">
                        <div class="media p-4">
                            <div class="align-self-center mr-3 rounded-circle notify-icon">
                                <img src="{{ asset('/img/uploads') . '/' . $admin->profile_image }}" alt="profilePic" class="rounded-circle" width="50" height="50">
                            </div>
                            <div class="media-body pl-2">
                                <h5 class="mt-0 mb-0"><strong><a href="{{ route('admin.user.show', $admin->id) }}" class="bootstrap-link">{{ $admin->first_name }} {{ $admin->last_name }} ({{ $admin->username }})</a></strong></h5>
                                <p><small class="text-muted bc-description">{{ ucfirst($admin->type) }}</small></p>
                                <p><small class="text-muted bc-description">{{ $admin->email }}</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-lg-4 col-md-4 col-sm-4 col-12 mb-3 user-card">
                <p>Keine Administratoren gefunden!</p>
            </div>
        @endif
    </div>
@endsection