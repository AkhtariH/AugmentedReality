@extends('layout.app')

@section('title', 'Startseite')

@section('content')
    <div class="custom-header">
        <h3>Zeiterfassung <a href="{{ route('dashboard.create') }}" class="badge badge-success" style="font-size: 12px;"><i class="fa fa-plus"></i> Neuer Eintrag</a></h3>
    </div>
    <span class="text-secondary">Dashboard <i class="fa fa-angle-right"></i> Zeiterfassung</span>
    

    <div class="row" style="margin-top: 20px;">
        <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
            <div class="bg-theme border shadow">
                <div class="media p-4">
                    <div class="align-self-center mr-3 rounded-circle notify-icon bg-white">
                        <i class="fas fa-user-friends text-theme"></i>
                    </div>
                    <div class="media-body pl-2">
                        <h3 class="mt-0 mb-0"><strong>@if(isset($supervisor)) {{ $supervisor->first_name . ' ' . $supervisor->last_name }} @else {{ '-' }} @endif</strong></h3>
                        <p><small class="bc-description text-white">Vorgesetzte</small></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
            <div class="bg-theme border shadow">
                <div class="media p-4">
                    <div class="align-self-center mr-3 rounded-circle notify-icon bg-white">
                        <i class="fas fa-stopwatch text-theme"></i>
                    </div>
                    <div class="media-body pl-2">
                        <h3 class="mt-0 mb-0"><strong>{{ ($overtime != null) ? $overtime : 0 }}</strong></h3>
                        <p><small class="bc-description text-white">Überstunden</small></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
            <div class="bg-theme border shadow">
                <div class="media p-4">
                    <div class="align-self-center mr-3 rounded-circle notify-icon bg-white">
                        <i class="fas fa-calendar-alt text-theme"></i>
                    </div>
                    <div class="media-body pl-2">
                        <h3 class="mt-0 mb-0"><strong>@if(isset($latestEntryDate)) {{ $latestEntryDate->date_to->format('d.m.Y') }} @else {{ '-' }} @endif</strong></h3>
                        <p><small class="bc-description text-white">Eingegeben bis</small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: 20px;">
        <div class="col-lg-4 col-md-4 col-sm-4"></div>
        <div class="col-lg-4 col-md-4 col-sm-4 card-calendar mb-3">
            <!--Calendar-->
            <div class="calendar-wrapper panel-head-info shadow">
                <div id="calendar" class="calendar-box" style="user-select: none;-webkit-user-select: none;-webkit-touch-callout: none;-khtml-user-select: none;-moz-user-select: none;-ms-user-select: none;"></div>
                <div class="dropdown-divider"></div>
            </div>
            <!--Calendar-->
            <div class="col-lg-4 col-md-4 col-sm-4"></div>
        </div>
    </div>
    <div class="mt-4 mb-4 p-3 bg-white border shadow-sm lh-sm">
        <!--Order Listing-->
        <div class="product-list">
            <div class="row border-bottom mb-4">
                <div class="col-sm-8 pt-2">
                    <h4 class="mb-4 bc-header" id="heading-filter" style="margin-bottom: 0px;display:inline;">Filter</h4><span id="filter-date" style="cursor:pointer;position: absolute;top: 6px;margin-left: 10px;"></span>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="date" id="date_from" class="form-control" placeholder="Start Datum">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="date" id="date_to" class="form-control" placeholder="End Datum">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <span class="badge badge-warning" style="width: 20px;height: 20px;vertical-align: middle;margin-top: 3px;"> </span> <span style="vertical-align: middle; margin-top: 15px;">Urlaub</span>
                            </div>
                        </div>

                </div>
                <div class="col-sm-4 text-right pb-3">
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="table-responsive product-list">
                
                <table class="table table-striped table-bordered dataTable" id="productList" role="grid">
                    <thead>
                        <tr role="row">
                            <th>Eintrag #</th>
                            <th>Von</th>
                            <th>Bis</th>
                            <th>Uhrzeit</th>
                            <th>Arbeitszeit</th>
                            <th>Pause</th>
                            <th>Aktion</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($entries as $entry)
                            <tr class="{{ ($entry->entry_type_id == 2) ? 'table-warning' : ''}}">
                                <td>{{ $entry->id }}</td>
                                <td>{{ $entry->date_from->format('d.m.Y') }}</td>
                                <td>{{ $entry->date_to->format('d.m.Y') }}</td>
                                {{-- um {{ $entry->time_to->format('H:i') }} --}}
                                <td>{{ $entry->time_from->format('H:i') }} bis {{ $entry->time_to->format('H:i') }} Uhr</td>
                                <td>{{ $entry->hours }}</td>
                                <td>{{ $entry->break_in_minutes }} Minuten</td>
                                <td class="align-middle text-center">
                                    <a href="{{ route('dashboard.show', $entry->id) }}">
                                        <button class="btn btn-theme" data-toggle="modal" data-target="#orderInfo">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </a>
                                    <a href="{{ route('dashboard.edit', $entry->id) }}">
                                        <button class="btn btn-success" data-toggle="modal" data-target="#orderUpdate">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
        <!--/Order Listing-->
    </div>

    {{-- <div class="row pagination">
        {!! $bridges->links() !!}
    </div> --}}
@endsection

@section('inclusions')
    @parent
    <script src="{{ asset('/js/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="https://cdn.datatables.net/scroller/2.0.1/js/dataTables.scroller.js"></script>
    <script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
    
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.js"></script>
    <script>
        Date.prototype.ddmmyyyy = function() {
            var mm = this.getMonth() + 1; // getMonth() is zero-based
            var dd = this.getDate();

            return [(dd>9 ? '' : '') + dd,
                    (mm>9 ? '' : '') + mm,
                    this.getFullYear()
                    ].join('/');
        };
        $(document).ready( function(){
            var cTime = new Date(), month = cTime.getMonth()+1, year = cTime.getFullYear();
            var entries = {!! str_replace("'", "\'", json_encode($entries)) !!};
            theMonths = ["Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"];
            theDays = ["So", "Mo", "Di", "Mi", "Do", "Fr", "Sa"];
            var events = [];
            entries.forEach(element => {
                var date_from = element.date_from.substr(0, element.date_from.indexOf('T'));
                var date_to = element.date_to.substr(0, element.date_to.indexOf('T'));
                var time_from_long = element.time_from.substr(element.time_from.indexOf('T') + 1, element.time_from.length);
                var time_from = time_from_long.substr(0, time_from_long.indexOf('.'));
                var time_to_long = element.time_to.substr(element.time_to.indexOf('T') + 1, element.time_to.length);
                var time_to = time_to_long.substr(0, time_to_long.indexOf('.'));
                var id = element.id.toString();
                var entry_type = "";
                var entry_color = "";
                if (element.entry_type_id == 2) {
                    entry_type = "Urlaub";
                    entry_color = "#fcc633";
                } else {
                    entry_type = "Arbeit";
                    entry_color = "#177bbb";
                }
                var now = new Date(date_to);
                var daysOfYear = [];
                for (var d = new Date(date_from); d <= now; d.setDate(d.getDate() + 1)) {
                    var date = new Date(d);
                    date = date.ddmmyyyy();
                    events.push([
                        date,
                        entry_type + '<a href="/dashboard/' + id + '/edit" style=""><span style="font-size: 12.5px;margin-left: 10px;"><i class="fas fa-pencil-alt" style="color: #333;"></i></span></a>',
                        '#',
                        entry_color,
                        time_from + ' - ' + time_to
                    ]);
                }
            });

            console.log(events);
            
            // events = [
            // [
            //     "4/"+month+"/"+year, 
            //     'Meet a friend', 
            //     '#', 
            //     '#177bbb', 
            //     'Contents here'
            // ],
            // [
            //     "7/"+month+"/"+year, 
            //     'Kick off meeting!', 
            //     '#', 
            //     '#1bbacc', 
            //     'Have a kick off meeting with .inc company'
            // ],
            // [
            //     "17/"+month+"/"+year, 
            //     'Milestone release', 
            //     '#', 
            //     '#fcc633', 
            //     'Contents here'
            // ],
            // [
            //     "19/"+month+"/"+year, 
            //     'A link', 
            //     'http://www.google.com', 
            //     '#e33244'
            // ]
            // ];
            $('#calendar').calendar({
                months: theMonths,
                days: theDays,
                events: events,
                popover_options:{
                    placement: 'top',
                    html: true
                }
            });
        });

        var oTable = $('#productList').DataTable({
            "lengthChange": false,
            "searching": true,
            "dom": 'lrtip',
            "order": [[ 2, 'desc' ]],
            columnDefs: [
         {
           targets: [2],
           type: 'date'
         }
        ],
            'language': {
                    "decimal":        "",
                    "emptyTable":     "Keine Einträge verfügbar.",
                    "info":           "Zeige _START_ bis _END_ von _TOTAL_ Einträgen",
                    "infoEmpty":      "Zeige 0 bis 0 von 0 Einträgen",
                    "infoFiltered":   "(gefiltert von _MAX_ Einträgen)",
                    "infoPostFix":    "",
                    "thousands":      ",",
                    "lengthMenu":     "Show _MENU_ entries",
                    "loadingRecords": "Loading...",
                    "processing":     "Processing...",
                    "search":         "Search:",
                    "zeroRecords":    "Keine Einträge gefunden!",
                    "paginate": {
                        "first":      "First",
                        "last":       "Last",
                        "next":       "<i class='fas fa-chevron-right'></i>",
                        "previous":   "<i class='fas fa-chevron-left'></i>"
                    },
                    "aria": {
                        "sortAscending":  ": activate to sort column ascending",
                        "sortDescending": ": activate to sort column descending"
                    }
                }
        });
        var successMsg = '{{ session("success") }}';
        if (successMsg != '' && successMsg != null) {
            $.notify({
              // options
              message: '<span style="font-size: 15px;"><i class="fas fa-check-circle"></i></span> ' + successMsg 
            },{
              // settings
              type: 'success',
              allow_dismiss: true,
              newest_on_top: true,
              showProgressbar: false,
            });
        }


        $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {

            var valid = true;
            var min = moment($("#date_from").val(), 'DD/MM/YYYY');
            if (!min.isValid()) { min = null; }
            console.log(min);

            var max = moment($("#date_to").val(), 'DD/MM/YYYY');
            if (!max.isValid()) { max = null; }

            if (min === null && max === null) {
                // no filter applied or no date columns
                valid = true;
            }
            else {

                $.each(settings.aoColumns, function (i, col) {
                    
                    if (col.type == "date") {
                        var cDate = moment(data[i],'DD.MM.YYYY');
                    console.log(cDate);
                    
                        if (cDate.isValid()) {
                            if (max !== null && max.isBefore(cDate)) {
                                valid = false;
                            }
                            if (min !== null && cDate.isBefore(min)) {
                                valid = false;
                            }
                        }
                        else {
                            valid = false;
                        }
                    }
                });
            }
            return valid;
    });


            $('#filterSubmit').on('click', function() {

                    $('#filter-date').html('<span class="badge badge-danger"><i class="fas fa-times"></i> Entfernen</span>');
                    $('#productList').DataTable().draw();
                
            });

            $('#date_to').on('keyup', function() {
                var min = moment($("#date_from").val(), 'DD/MM/YYYY');
                var max = moment($("#date_to").val(), 'DD/MM/YYYY');
                if (min.isValid() && max.isValid()) { 
                    $('#productList').DataTable().draw();
                    $('#filter-date').html('<span class="badge badge-danger"><i class="fas fa-times"></i> Entfernen</span>');
                }
            });



            $('#filter-date').on('click', function () {
                $('#filter-date').html('');
                $("#date_from").val('');
                $("#date_to").val('');
                $('#productList').DataTable().draw();

            });
    </script>
@endsection
