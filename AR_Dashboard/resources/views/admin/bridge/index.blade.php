@extends('layout.app')

@section('title', 'Manage bridges')

@section('content')
    @if (session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    <div class="custom-header">
        <h3>Bridges <a href="{{ route('admin.bridge.create') }}" class="badge badge-success"><i class="fa fa-plus"></i> Add bridge</a></h3>
    </div>
    <hr/>
    <div class="row pl-0">
        @if (!$bridges->isEmpty())
            @foreach ($bridges as $bridge)
                <div class="col-lg-4 col-md-4 col-sm-4 col-12 mb-3 user-card">
                    <form action="{{ route('admin.bridge.destroy', $bridge->id) }}" method="post" class="removeForm">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="deleteButton close" onclick="return confirm('Are you sure?')">
                            <i class="far fa-times-circle"></i>
                        </button>
                    </form>
                    <div class="bg-white border shadow">
                        <div class="media p-4">
                            <div class="align-self-center mr-3 rounded-circle notify-icon">
                                @if ($bridge->error == false)
                                    <i class="far fa-check-circle sensor-good"></i>
                                @else
                                    <i class="fas fa-exclamation-triangle sensor-error"></i>
                                @endif
                            </div>
                            <div class="media-body pl-2">
                                <h5 class="mt-0 mb-0"><strong><a href="{{ route('admin.bridge.show', $bridge->id) }}" class="bootstrap-link">{{ $bridge->name }}</a></strong> <a href="{{ route('admin.bridge.edit', $bridge->id) }}"><span class="edit-user"><i class="fas fa-pencil-alt"></i></span></a></h5>
                                <p><small class="text-muted bc-description">{{ ucfirst($bridge->adress) }}</small></p>
                                <p><small class="text-muted bc-description">Supervisor: {{ $bridge->supervisor }}</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-lg-4 col-md-4 col-sm-4 col-12 mb-3 user-card">
                <p>There are no connected bridges!</p>
            </div>
        @endif
    </div>

    <div class="row pagination">
        {!! $bridges->links() !!}
    </div>
@endsection