@extends('layout.app')

@section('title', 'Eintrag bearbeiten')

@section('content')
<div class="custom-header">
    <h3>Eintrag #{{ $holiday->id }} bearbeiten</h3>
</div>
<span class="text-secondary">Administrator Panel <i class="fa fa-angle-right"></i> Stundenverwaltung <i class="fa fa-angle-right"></i> Eintrag #{{ $holiday->id }} <i class="fa fa-angle-right"></i> Bearbeiten</span>
<div class="mt-1 mb-5 button-container" style="margin-top: 20px !important;">
    <div class="card shadow-sm">
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">{{$errors->first()}}</div>
            @endif
            <form action="{{ route('admin.holiday.update', $holiday->id) }}" method="POST" id="main-mask" class="mt-2 has-validation-callback">
                @csrf
                @method('put')
                <div class="test-container" style="max-width: 900px;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" id="name" value="{{ $holiday->name }}" name="name" class="form-control" placeholder="Name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="holiday_date">Datum</label>
                                <input type="date" id="holiday_date" name="holiday_date" value="{{ $holiday->holiday_date->format('d/m/Y') }}" class="form-control" placeholder="TT/MM/YYYY" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary btn-block p-2 mb-1" type="submit" name="submit">Speichern</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('inclusions')
    @parent
    <script src="{{ asset('js/form-validator/jquery.form-validator.min.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script> --}}
    <script>




    
    </script>
@endsection