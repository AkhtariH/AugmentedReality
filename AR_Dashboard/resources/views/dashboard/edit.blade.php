@extends('layout.app')

@section('title', 'Neuer Eintrag')

@section('content')
<div class="custom-header">
    <h3>Eintrag #{{ $entry->id }} bearbeiten</h3>
</div>
<span class="text-secondary">Dashboard <i class="fa fa-angle-right"></i> Zeiterfassung <i class="fa fa-angle-right"></i> Eintrag #{{ $entry->id }} <i class="fa fa-angle-right"></i> Bearbeiten</span>

<div class="mt-1 mb-5 button-container" style="margin-top: 20px !important;">
    <div class="card shadow-sm">
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">{{$errors->first()}}</div>
            @endif
            <form action="{{ route('dashboard.update', $entry->id) }}" id="main-mask" method="POST" class="mt-2">
                @csrf
                @method('put')
                <div class="test-container" style="max-width: 900px;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="reason">Begründung</label>
                                <textarea rows="5" class="form-control" id="reason" name="edit_reason" placeholder="Grund der Bearbeitung..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="blurred" style="  -webkit-touch-callout: none; /* iOS Safari */
                    -webkit-user-select: none; /* Safari */
                     -khtml-user-select: none; /* Konqueror HTML */
                       -moz-user-select: none; /* Old versions of Firefox */
                        -ms-user-select: none; /* Internet Explorer/Edge */
                            user-select: none;pointer-events:none;-webkit-filter: blur(10px);-moz-filter: blur(5px);-o-filter: blur(5px);-ms-filter: blur(5px);filter: blur(10px);">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id">ID</label>
                                    <input type="text" id="id" readonly class="form-control" placeholder="{{ Auth()->user()->id }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Mitarbeiter</label>
                                    <input type="text" id="name" readonly class="form-control" placeholder="{{ Auth()->user()->first_name }} {{ Auth()->user()->last_name }}">
                                </div>
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hpd">Stunden pro Woche</label>
                                    <input type="text" id="hpd" readonly class="form-control" placeholder="{{ $hpd->hours_per_week }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="entry_type">Eintragstyp</label>
                                    <select class="form-control" name="entry_type_id" id="entry_type_id">
                                        <option value="work" {{ ($entry->entry_type_id == 1) ? 'selected' : ''}}>Arbeitszeit</option>
                                        <option value="vacation" {{ ($entry->entry_type_id == 2) ? 'selected' : ''}}>Urlaub</option>
                                    </select>
                                </div>
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date_from">Start Datum</label>
                                    <input type="date" id="date_from" name="date_from" class="form-control" value="{{ $entry->date_from->format('d/m/Y') }}" max="{{ \Carbon\Carbon::now()->addMonth()->toDateString() }}" placeholder="TT/MM/YYYY">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date_to">End Datum</label>
                                    <input type="date" id="date_to" name="date_to" class="form-control" value="{{ $entry->date_to->format('d/m/Y') }}" max="{{ \Carbon\Carbon::now()->addMonth()->toDateString() }}" placeholder="TT/MM/YYYY">
                                </div>
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="time_from">Start Uhrzeit</label>
                                    <input type="time" id="time_from" name="time_from" class="form-control" value="{{ $entry->time_from->format('H:i') }}" placeholder="HH:MM">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="time_to">End Uhrzeit</label>
                                    <input type="time" id="time_to" name="time_to" class="form-control" value="{{ $entry->time_to->format('H:i') }}" placeholder="HH:MM">
                                </div>
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="break_in_minutes">Pause <small>(in Minuten)</small></label>
                                    <input type="number" id="break_in_minutes" name="break_in_minutes" class="form-control" value="{{ $entry->break_in_minutes }}" placeholder="Pause">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="working_hour">Arbeitszeit</label>
                                    <input type="text" name="working_hour" id="working_hour" readonly class="form-control" placeholder="-">
                                </div>
                            </div>
                        </div>
    
                        <div class="form-group">
                            <input type="hidden" name="hour_per_day_id" id="hpd_id" value="{{ $entry->hour_per_day_id }}">
                            <button class="btn btn-primary btn-block p-2 mb-1" id="main-submit" type="submit" name="submit-main">Speichern</button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('inclusions')
    @parent
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script> --}}
    <script>

        $(document).ready(function () {
            $('#main-submit').on('click', function(event) {
                event.preventDefault();
                if ($('#date_from').val().includes('/')) {
                    $('#date_from').val($('#date_from').val().split("/").reverse().join("-"));
                }

                if ($('#date_to').val().includes('/')) {
                    $('#date_to').val($('#date_to').val().split("/").reverse().join("-"));
                }

                $('#main-mask').submit();

            });
        });

        Number.prototype.pad = function(size) {
            var s = String(this);
            while (s.length < (size || 2)) {s = "0" + s;}
            return s;
        };


        var hours = ((parseInt($("#time_to").val().split(':')[0], 10) - parseInt($("#time_from").val().split(':')[0], 10)) * 60) - parseInt($('#break_in_minutes').val()) + (parseInt($("#time_to").val().split(':')[1], 10) - (parseInt($("#time_from").val().split(':')[1], 10)));
        const [d, M, y] = $('#date_from').val().match(/\d+/g);
        const [d2, M2, y2] = $('#date_to').val().match(/\d+/g);
        const D = new Date(y, M-1, d);
        const D2 = new Date(y2, M2-1, d2); 

        const diffTime = Math.abs(D2 - D);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; 
        if (hours > 0) {
            var working_hours_in_minutes = (hours * diffDays);
            var hours = Math.floor(working_hours_in_minutes / 60);
            var minutes = (working_hours_in_minutes % 60);

            $('#working_hour').val(hours.pad(2) + 'h ' + minutes.pad(2) + 'min');
        } else {
            $('#working_hour').val('-');
        }

        
        $('#reason').on('input', function() {
            if ($('#reason').val().length >= 5) {
                $('.blurred').css({
                    'filter':'blur(0px)',
                    'user-select':'auto',
                    'pointer-events':'auto'
                });
            } else {
                $('.blurred').css({
                    'filter':'blur(10px)',
                    'user-select':'none',
                    'pointer-events':'none'
                });               
            }
        });

        $('input').on('input', function() {
        
            
            // Arbeitszeit
            var dateExp = new RegExp(/^\d{1,2}\/\d{1,2}\/\d{4}$/);
            var dateExpAm = new RegExp(/([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))/);
            var timeExp = new RegExp(/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/);
            if ((dateExp.test($('#date_from').val()) 
                && dateExp.test($('#date_to').val())
                || dateExpAm.test($('#date_from').val()) && dateExpAm.test($('#date_to').val()))
                && timeExp.test($('#time_from').val())
                && timeExp.test($('#time_to').val())
                && $('#break_in_minutes').val().length > 0) {
                    
                var hours = ((parseInt($("#time_to").val().split(':')[0], 10) - parseInt($("#time_from").val().split(':')[0], 10)) * 60) - parseInt($('#break_in_minutes').val()) + (parseInt($("#time_to").val().split(':')[1], 10) - (parseInt($("#time_from").val().split(':')[1], 10)));

                var D, D2;
                if (dateExpAm.test($('#date_from').val()) && dateExpAm.test($('#date_to').val())) {
                    D = new Date($('#date_from').val());
                    D2 = new Date($('#date_to').val());
                } else {
                    const [d, M, y] = $('#date_from').val().match(/\d+/g);
                    const [d2, M2, y2] = $('#date_to').val().match(/\d+/g);
                    D = new Date(y, M-1, d);
                    D2 = new Date(y2, M2-1, d2); 
                }


                const diffTime = Math.abs(D2 - D);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; 
                if (hours > 0) {
                    var working_hours_in_minutes = (hours * diffDays);
                    var hours = Math.floor(working_hours_in_minutes / 60);
                    var minutes = (working_hours_in_minutes % 60);

                    $('#working_hour').val(hours.pad(2) + 'h ' + minutes.pad(2) + 'min');
                } else {
                    $('#working_hour').val('-');
                }
            }

            // Stunden pro Tag
            if ((dateExp.test($('#date_from').val()) && dateExp.test($('#date_to').val()))
                || dateExpAm.test($('#date_from').val()) && dateExpAm.test($('#date_to').val())) {
                var date = $('#date_from').val();
                var date2 = $('#date_to').val();
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/hpd',
                    data: { date_from: date, date_to: date2 },
                    success: function(msg) {
                        $('#hpd').val(msg[0]);
                        $('#hpd_id').val(msg[1]);
                    }
                }); 
            } else {
                $('#hpd').val('-');
            }
            

        });

    
    </script>
@endsection