@extends('layout.app')

@section('title', 'Detailseite')

@section('content')
  <div class="custom-header">
    <h3>Eintrag #{{ $entry->id }}</h3>
    <a href="{{ route('dashboard.edit', $entry->id) }}" style="vertical-align: middle;"><span style="font-size: 17px;"><i class="fas fa-pencil-alt" style="vertical-align: middle;color: #333;"></i></span></a>
  </div>
  <span class="text-secondary">Dashboard <i class="fa fa-angle-right"></i> Zeiterfassung <i class="fa fa-angle-right"></i> Eintrag #{{ $entry->id }}</span>

    
    @if ($entry->edit_from_name != '')
      <p class="text-secondary" style="margin-top: 10px;"><small>Bearbeitet von: {{ $entry->edit_from_name }}, {{ $entry->edit_update }}</small></p>
      <p class="text-secondary"><small>Begründung: {{ $entry->edit_reason }}</small></p>
    @endif

    <div class="mt-1 mb-5 button-container" style="margin-top: 20px !important;">
      <div class="card shadow-sm">
          <div class="card-body" style="height: 160px;">
            <div class="row">
              <div class="col-md-6">
                <p class="p-typo border-bottom"><strong>Mitarbeiter ID:</strong> {{ Auth()->user()->id }}</p>
                <p class="p-typo border-bottom"><strong>Mitarbeiter:</strong> {{ Auth()->user()->first_name }} {{ Auth()->user()->last_name }}</p>
                <p class="p-typo border-bottom"><strong>Stunden pro Tag:</strong> {{ $hpd->hours_per_week }}</p>

              </div>
              <div class="col-md-6">
                <p class="p-typo border-bottom"><strong>Von:</strong> {{ $entry->date_from->format('d/m/Y') }} um {{ $entry->time_from->format('H:i') }}</p>
                <p class="p-typo border-bottom"><strong>Bis:</strong> {{ $entry->date_to->format('d/m/Y') }} um {{ $entry->time_to->format('H:i') }}</p>
                <p class="p-typo border-bottom"><strong>Pause:</strong> {{ $entry->break_in_minutes }} Minuten</p>
                <p class="p-typo border-bottom"><strong>Arbeitszeit:</strong> {{ $entry->hours }}</p>
              </div>
            </div>
          </div>
      </div>
    </div>

<!--/Content types-->
@endsection

@section('inclusions')
    @parent
    <script src="{{ asset('js/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('js/socket.io.js') }}"></script>
    <script src="{{ url('/js/laravel-echo-setup.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        window.Echo.channel('sensor-channel')
         .listen('.UpstreamEvent', (data) => {
           if ($('.device').data('device')) {
            $.notify({
              // options
              
              message: '<span style="font-size: 20px;"><i class="fas fa-bell"></i></span> New data from device <strong>' + data.id + '</strong>!'  
            },{
              // settings
              type: 'danger',
              allow_dismiss: true,
              newest_on_top: true,
              showProgressbar: true,
            });

            data.sensors.forEach(element => {
              var sensor = $('.device[data-device="' + data.id + '"]').find('.sensor[data-sensor="' + element.id + '"]');
              var threshold = sensor.find('.threshold').html();

              sensor.find('#sensor-data').html(element.data);

              if (element.data >= threshold) {
                sensor.find('.notify-icon').html('<i class="fas fa-exclamation-triangle sensor-error"></i>');
              } else {
                sensor.find('.notify-icon').html('<i class="far fa-check-circle sensor-good"></i>');
              }
            });
           }

        });
    </script>
@endsection