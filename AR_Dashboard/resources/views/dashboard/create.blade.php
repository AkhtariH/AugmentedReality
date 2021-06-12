@extends('layout.app')

@section('title', 'Neuer Eintrag')

@section('content')
<div class="custom-header">
    <h3>Neuer Eintrag</h3>
</div>
<span class="text-secondary">Dashboard <i class="fa fa-angle-right"></i> Zeiterfassung <i class="fa fa-angle-right"></i> Neuer Eintrag</span>
<div class="mt-1 mb-5 button-container" style="margin-top: 20px !important;">
    <div class="card shadow-sm">
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">{{$errors->first()}}</div>
            @endif
            <form action="{{ route('dashboard.store') }}" method="POST" id="main-mask" class="mt-2 has-validation-callback">
                @csrf
                <div class="test-container" style="max-width: 900px;">
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
                                <input type="text" id="hpd" readonly class="form-control" placeholder="-">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="entry_type">Eintragstyp</label>
                                <select class="form-control" name="entry_type" id="entry_type">
                                    <option value="work" selected>Arbeitszeit</option>
                                    <option value="vacation">Urlaub</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date_from">Start Datum</label>
                                <input type="date" id="date_from" name="date_from" class="form-control" placeholder="TT/MM/YYYY" max="{{ \Carbon\Carbon::now()->addMonth()->toDateString() }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date_to">End Datum</label>
                                <input type="date" id="date_to" name="date_to" class="form-control" placeholder="TT/MM/YYYY" max="{{ \Carbon\Carbon::now()->addMonth()->toDateString() }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="time_from">Start Uhrzeit</label>
                                <input type="time" id="time_from" name="time_from" class="form-control" placeholder="HH:MM" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="time_to">End Uhrzeit</label>
                                <input type="time" id="time_to" name="time_to" class="form-control" placeholder="HH:MM" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="break_in_minutes">Pause <small>(in Minuten)</small></label>
                                <input type="number" id="break_in_minutes" value="0" name="break_in_minutes" class="form-control" placeholder="Pause" required>
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
                        <input type="hidden" name="hpd_id" id="hpd_id" value="">
                        <button class="btn btn-primary btn-block p-2 mb-1" id="main-submit" type="submit" name="main-submit">Speichern</button>
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

        window.addEventListener('beforeunload', function (e) {
            // Cancel the event
            e.preventDefault();
            // Chrome requires returnValue to be set
            e.returnValue = '';
        });
        Number.prototype.pad = function(size) {
            var s = String(this);
            while (s.length < (size || 2)) {s = "0" + s;}
            return s;
        };

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

                var hoursWithoutBreak = ((parseInt($("#time_to").val().split(':')[0], 10) - parseInt($("#time_from").val().split(':')[0], 10)) * 60) + (parseInt($("#time_to").val().split(':')[1], 10) - (parseInt($("#time_from").val().split(':')[1], 10)));
                hoursWithoutBreak = Math.floor(hoursWithoutBreak / 60);
                if (hoursWithoutBreak > 6 && hoursWithoutBreak <= 9) {
                    $('#break_in_minutes').val(30);
                    $('#break_in_minutes').attr('min', 30);
                } else if (hoursWithoutBreak > 9) {
                    $('#break_in_minutes').val(45);
                    $('#break_in_minutes').attr('min', 45);
                }
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

        // $('#date_from').datepicker({  
        //     format: 'mm-dd-yyyy'
        // });  

    
    </script>
@endsection