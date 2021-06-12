@extends('layout.app')

@section('title', $bridge->name)

@section('content')
    <!-- Skill bars-->
    <!-- <div class="mt-1 mb-3 p-3 button-container bg-white border shadow-sm">
                <h6 class="mb-2">Estimated lifespan</h6>
                
                <p class="mb-2 mt-3">lifespan <span class="pull-right">70%</span></p>
                <div class="progress mb-4" style="height: 7px;">
                    <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="70" style="width: 70%"  aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div> -->
    <!--/Skill bars -->

    <div class="modal fade" id="thresholdModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form>
                <div class="form-group">
                  <label for="recipient-name" class="col-form-label">Value:</label>
                  <input type="number" step="0.05" class="form-control" id="threshold">
                  <input type="hidden" id="sensorID" value="">
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="submitThreshold">Submit</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="sensorDetailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <p>Current value: <span id="currVal"></span></p>
                <br>
                <p>Graph</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

    <!--Content types-->
    <h4 class="inline">Bridge information</h4>
    <a href="{{ route('admin.bridge.edit', $bridge->id) }}"><span class="edit-bridge"><i class="fas fa-pencil-alt"></i></span></a>
    <hr/>
    <div class="mt-1 mb-5 button-container">
        <div class="card shadow-sm">
            <div class="card-body">

                
                <p class="p-typo"><strong>Name:</strong> {{ $bridge->name }}</p>
                <p class="p-typo"><strong>Address:</strong> {{ $bridge->adress }}</p>
                <p class="p-typo"><strong>Supervisor:</strong> {{ $bridge->supervisor }}</p>
            </div>
        </div>
    </div>

    <h4>Sensors</h4>
    <hr/>
    <div class="row pl-0 device" id="sensor-row" data-device="{{ $bridge->ttn_dev_id }}">
        @if (!$sensors->isEmpty())
            @foreach ($sensors as $sensor)
      <div class="col-lg-4 col-md-4 col-sm-4 col-12 mb-3 user-card sensor" data-sensor="{{ $sensor->ttn_sensor_id }}">
                <div class="bg-white border shadow">
                    <div class="media p-4">
                        <div class="align-self-center mr-3 rounded-circle notify-icon">
                            @if (count($sensor->data_collection) > 0 )
                                @if ($sensor->data_collection[0]->error == false)
                                    <i class="far fa-check-circle sensor-good"></i>
                                @else
                                    <i class="fas fa-exclamation-triangle sensor-error"></i>
                                @endif
                            @else 
                                <i class="far fa-check-circle sensor-good"></i>
                            @endif
                        </div>
                        <div class="media-body pl-2">
                            <h5 class="mt-0 mb-0">
                                <strong style="font-size: 16px;font-weight: 500 !important;">
                                    <a data-toggle="modal" id="sensorDetailTrigger-{{ $sensor->id }}" class="pointer" data-target="#sensorDetailModal" data-value="{{ implode(';', $sensor->data_collection) }}" data-name="{{ $sensor->name }}" data-currthreshold="{{ $sensor->threshold_value }}" data-type="{{ $sensor->type }}" data-attributes="{{ $sensor->data_attribute }}">
                                        {{ $sensor->name }}
                                    </a>
                                    @if (count($sensor->data_collection) > 1)
                                      - <span id="sensor-data">{{ $sensor->data_collection[0]->data }}</span>
                                    @else 
                                        - No Data
                                    @endif
                                </strong>
                            </h5>
                            <p><small class="text-muted bc-description"><strong>Type:</strong> {{ $sensor->type }}</small></p>
                            <p>
                                <small class="text-muted bc-description">
                                    Threshold: <span id="sensor-{{ $sensor->id }}" class="threshold">{{ $sensor->threshold_value }}</span>
                                    <a data-toggle="modal" class="pointer" data-target="#thresholdModal" data-value="{{ $sensor->threshold_value }}" data-id="{{ $sensor->id }}" data-name="{{ $sensor->name }}">
                                        <span class="edit-threshold"><i class="fas fa-pencil-alt"></i></span>
                                    </a>
                                </small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @else
        <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-3 user-card">
            <p>There are no sensors connected to the bridge!</p>
        </div>
        @endif
    </div>

    <h4>Assign accounts</h4>
    <hr/>
    <div class="row pl-0" id="sensor-row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-3 user-card">
        @if (!$users->isEmpty())
            @foreach ($users as $user)

                <input type="checkbox" class="form-check-input hidden" id="user-{{ $user->id }}" data-id="{{ $user->id }}" data-bridge="{{ $bridge->id }}" {{ $user->checked == true ? "checked" : "" }}>
                <label for="user-{{ $user->id }}" class="badge badge-secondary font-15">[{{ ucfirst(substr($user->type, 0, 1)) }}] {{ $user->name }}</label>
            @endforeach
        </div>
        @else  
            <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-3 user-card">
                <p>No users found!</p>
            </div>
        @endif
    </div>
    
    <h4 class="mb-2">Bridge location</h4>
    <hr/>
    <!--Google world-->
    <div class="mt-1 mb-3 p-3 button-container bg-white shadow-sm border">
        
        <div id="map" style="width: 100%; height: 300px"></div>
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
              delay: 20000,
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

    
    <script>
      if($("#map").length > 0){
        L.mapquest.key = 'HSpGQTU57l0axHugD5o7BjhWZbGnM7Ru';

        var bridge = {!! json_encode($bridge->toArray(), JSON_HEX_TAG) !!};
        var adress = bridge.adress;

        $.ajax({
            type: "POST",
            url: 'http://open.mapquestapi.com/geocoding/v1/address?key=HSpGQTU57l0axHugD5o7BjhWZbGnM7Ru',
            data: {
                "location": adress,
                "options": {
                  "thumbMaps": false
                }
            },
            success: function(msg) {
              var lat = msg.results[0].locations[0].displayLatLng.lat;
              var long = msg.results[0].locations[0].displayLatLng.lng;

              var map = L.mapquest.map('map', {
                center: [lat, long],
                layers: L.mapquest.tileLayer('map'),
                zoom: 16
              });

              L.mapquest.textMarker([lat, long], {
                text: bridge.name,
                subtext: adress + "<br>" + bridge.bridgeHash,
                position: 'right',
                type: 'marker',
                icon: {
                  primaryColor: '#DD3333',
                  secondaryColor: '#DD3333',
                  size: 'lg'
                }
              }).addTo(map);
            }
        });
          
      }
    </script>
@endsection