@extends('layout.app')

@section('title', 'Dashboard')
@section('subtitle', 'Edit Art Object: ' . $artObject->name)

@section('content')
@if($errors->any()) 

<div class="alert alert-danger">{{$errors->first()}}</div>
@endif

<div class="row">
    <div class="col-xl-12 col-xxl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body orders-summary">
                <div class="basic-form custom_file_input">
                    <form action="{{ route('home.update', $artObject->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <input type="text" name="name" value="{{ $artObject->name }}" class="form-control" placeholder="Name">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <textarea class="form-control" rows="5" name="description" placeholder="Description">{{ $artObject->description }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" id="file" name="file" class="custom-file-input">
                                        <label class="custom-file-label">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="input-group" style="margin-top: 20px">
                            <button type="submit" class="btn btn-primary" name="submit">
                                {{ __('Update') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
 </div>
@endsection

@section('scripts')
<script>
    document.getElementById('file').onchange = function () {
        $('.custom-file-label').html(this.value);
    };
</script>
@endsection