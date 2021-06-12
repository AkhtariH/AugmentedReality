@extends('layout.app')

@section('title', 'Edit bridge')

@section('content')
<div class="mt-1 mb-5 button-container">
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="mb-2">Edit bridge</h3>
            <small class="">Edit an existing bridge.</small>
            @if($errors->any())
                <div class="alert alert-danger">{{$errors->first()}}</div>
            @endif
            <form action="{{ route('admin.bridge.update', $bridge->id) }}" method="POST" class="mt-2">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" value="{{ $bridge->name }}" class="form-control" id="name" name="name" placeholder="e.g. Bridge 1">
                </div>

                <div class="form-group">
                    <label for="name">Adress</label>
                    <input type="adress" value="{{ $bridge->adress }}" class="form-control" id="adress" name="adress" placeholder="e.g. Grote Markt, Groningen">
                </div>

                <div class="form-group">
                    <label for="name">Supervisor</label>
                    <input type="text" value="{{ $bridge->supervisor }}" class="form-control" id="supervisor" name="supervisor" placeholder="Supervisor">
                </div>

                <div class="form-group">
                    <label for="name">Bridge hash</label>
                    <input type="text" value="{{ $bridge->bridgeHash }}" class="form-control" id="bridgeHash" name="bridgeHash" placeholder="e.g. 1KIJO0JE">
                </div>
        
                <div class="form-group">
                    <button class="btn btn-light btn-block p-2 mb-1" type="submit" name="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection