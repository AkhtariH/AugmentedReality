@extends('layout.app')

@section('title', 'Eintrag bearbeiten')

@section('content')
<div class="custom-header">
    <h3>Eintrag #{{ $entry->id }} bearbeiten</h3>
</div>
<span class="text-secondary">Administrator Panel <i class="fa fa-angle-right"></i> Stundenverwaltung <i class="fa fa-angle-right"></i> Eintrag #{{ $entry->id }} <i class="fa fa-angle-right"></i> Bearbeiten</span>
<div class="mt-1 mb-5 button-container" style="margin-top: 20px !important;">
    <div class="card shadow-sm">
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">{{$errors->first()}}</div>
            @endif
            <form action="{{ route('admin.hpd.update', $entry->id) }}" method="POST" id="main-mask" class="mt-2 has-validation-callback">
                @csrf
                @method('put')
                <div class="test-container" style="max-width: 900px;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username">Mitarbeiter</label>
                                <input type="text" id="username" value="{{ $dbUser->username }}" name="username" class="form-control" placeholder="Netzwerkname">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="max_hours">Stunden pro Woche</label>
                                <input type="number" id="max_hours" name="hours_per_week" value="{{ $entry->hours_per_week }}" class="form-control" placeholder="Stunden pro Woche">
                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date_from">Start Datum</label>
                                <input type="date" id="date_from" name="date_from" value="{{ $entry->date_from->format('d/m/Y') }}" class="form-control" placeholder="TT/MM/YYYY" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date_to">End Datum</label>
                                <input type="date" id="date_to" name="date_to" value="{{ $entry->date_to->format('d/m/Y') }}" class="form-control" placeholder="TT/MM/YYYY" required>
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

        var availableTags = '{{ implode(",", $userArr) }}'.split(',');

        $( "#username" ).autocomplete({
                source: availableTags
        });


    
    </script>
@endsection