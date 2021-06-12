@extends('layout.app')

@section('title', $user->first_name . ' ' . $user->last_name)

@section('content')

    <div class="custom-header">
        <h3>{{ $user->first_name }} {{ $user->last_name }}</h3>
    </div>
    <span class="text-secondary">Administrator Panel <i class="fa fa-angle-right"></i> Benutzerverwaltung <i class="fa fa-angle-right"></i> {{ $user->first_name }} {{ $user->last_name }}</span>

    <div class="row" style="margin-top: 20px;">
        <div class="col-lg-12 col-md-12 col-sm-12 card-pro mb-3">
            <div class="card shadow">
                <div class="card-body">
                    <div class="media">
                        <img class="align-self-center mr-3 rounded-circle" src="{{ asset('/img/uploads') . '/' . $user->profile_image }}" width="100px" height="100px" alt="Generic placeholder image">
                        <div class="media-body">
                            <h5 class="mt-0"><strong>{{ $user->first_name }} {{ $user->last_name }} ({{ $user->username }})</strong></h5>
                            <p class="mb-3 text-info"><strong>{{ ucfirst($user->type) }}</strong></p>
                            <span id="supervisor-field">
                                @if ($supervisor != null)
                                    <p class="mb-3 text-secondary">
                                        <i class="fas fa-user-friends"></i> <strong>{{ $supervisor->first_name }} {{ $supervisor->last_name }}</strong> <span style="margin-left: 5px;font-size: 12.5px;cursor: pointer;" class="text-secondary" id="edit-supervisor" onclick="openForm()"><i class="fas fa-pencil-alt"></i></span><span style="margin-left: 10px;vertical-align:middle;cursor: pointer;font-size:12.5px;" onclick="deleteAssign()"><i class="fas fa-times"></i></span>
                                    </p>
                                @else
                                    <p class="mb-3 text-secondary"><span style="margin-left: 5px;font-size: 12.5px;cursor: pointer;" class="text-secondary" id="edit-supervisor" onclick="openForm()"><i class="fas fa-plus" style="color: #17a2b8;"></i> Vorgesetzten hinzufügen</i></span></p>
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="mt-4 mb-4 text-center">
                        <div class="row user-about">
                            <div class="col-sm-4 col-4 border-right">
                                <h4>{{ $user->id }}</h4>
                                <p>ID</p>
                            </div>
                            <div class="col-sm-4 col-4">

                                <h4>{{ $entries->count() }}</h4>
                                <p>Einträge</p>
                            </div>
                            <div class="col-sm-4 col-4 border-left">
                                <h4>{{ ($overtime != null) ? $overtime : 0 }}</h4>
                                <p>Überstunden</p>
                            </div>
                        </div>
                    </div>

                    <div class="dropdown-divider"></div>

                    <div class="mb-3 mt-3 p-space">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="mb-4 bc-header"><strong><i class="fas fa-cog"></i> Einstellungen</strong></h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <input type="checkbox" id="overtime_email" class="js-medium" @if ($user->overtime_email == true)  checked @endif> <label for="overtime_email" style="margin-left: 5px;">Überstunden E-Mail</label>
                                <div id="max_hours_input" style="display: inline;margin-left: 10px;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 mt-3 p-space">
                        <div class="product-list">
                            <div class="row mb-4">
                                <div class="col-sm-8 pt-2">
                                    <h4 class="mb-4 bc-header" id="heading-filter" style="margin-bottom: 0px;display:inline;"><strong><i class="far fa-calendar-alt"></i> Zeiterfassung</strong></h4>
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
                                            <th>Aktion</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($entries as $entry)
                                            <tr>
                                                <td>{{ $entry->id }}</td>
                                                <td>{{ $entry->date_from->format('d.m.Y') }}</td>
                                                <td>{{ $entry->date_to->format('d.m.Y') }}</td>
                                                {{-- um {{ $entry->time_to->format('H:i') }} --}}
                                                <td>{{ $entry->time_from->format('H:i') }} bis {{ $entry->time_to->format('H:i') }} Uhr</td>
                                                <td>{{ $entry->hours }}</td>
                                                <td class="align-middle text-center">
                                                    <a href="{{ route('dashboard.show', $entry->id) }}">
                                                        <button class="btn btn-theme" data-toggle="modal" data-target="#orderInfo">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<!--/Content types-->
@endsection

@section('inclusions')
    @parent
    <script src="{{ asset('/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="https://cdn.datatables.net/scroller/2.0.1/js/dataTables.scroller.js"></script>
    <script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
        var elem = document.querySelector('.js-medium');
        var init = new Switchery(elem, { size: 'small' });

        $(function() {
            if ($('#overtime_email').is(':checked')) {
                $("#max_hours_input").html("<input type='number' style='width:165px;display: inline;' onChange='maxOvertimeChange(this)' placeholder='Max. Überstunden' value='{{ ($user->max_overtime != null) ? $user->max_overtime : ""}}' id='max_overtime' name='max_overtime' class='form-control mt-0'>");
            } else {
                $("#max_hours_input").html('');
            }
        });

        function maxOvertimeChange(input) {
            var value = input.value;
            var userID = '{{ $user->id }}';
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/admin/user/overtime/max',
                data: { value: value, user: userID },
                success: function(msg) {
                    //input.value = value;
                },
                error: function(msg) {
                    console.log(msg);
                }
            });
        }

        $('#overtime_email').on('change', function () {
            var userID = '{{ $user->id }}';
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/admin/user/overtime',
                data: { data: this.checked, user: userID },
                success: function(msg) {
                    console.log(msg);
                },
                error: function(msg) {
                    console.log(msg);
                }
            }); 

            if (this.checked) {
                $("#max_hours_input").html("<input type='number' style='width:165px;display: inline;' onChange='maxOvertimeChange(this)' placeholder='Max. Überstunden' value='{{ ($user->max_overtime != null) ? $user->max_overtime : ""}}' id='max_overtime' name='max_overtime' class='form-control mt-0'>");
            } else {
                $("#max_hours_input").html('');
            }
        });

        var oTable = $('#productList').DataTable({
            "lengthChange": false,
            "pageLength": 3,
            "searching": true,
            "dom": 'lrtip',
            "order": [[ 0, 'desc' ]],
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

        

        function openForm() {
            var availableTags = '{{ implode(",", $supervisorsArr) }}'.split(',');
            $('#supervisor-field').html('<div class="input-group mb-3" style="max-width: 250px;"><div class="input-group-prepend" style="height: 30px;"><span class="input-group-text" id="basic-addon1"><i class="fas fa-user-friends"></i></span></div><input type="text" style="height: 30px;" class="form-control mt-0 text-secondary" id="supervisor-autocomplete" placeholder="Vorgesetzter" aria-label="Vorgesetzter" aria-describedby="basic-addon1"> <span style="margin-left: 10px;color: #29A744;vertical-align:middle;cursor: pointer;" id="supervisor-submit" onclick="check()"><i class="fas fa-check"></i></span></div>');
            $( "#supervisor-autocomplete" ).autocomplete({
                source: availableTags
            });
        }

        function check() {
            var availableTags = '{{ implode(",", $supervisorsArr) }}'.split(',');
            if (availableTags.includes($('#supervisor-autocomplete').val())) {
                var data = $('#supervisor-autocomplete').val();
                var userID = '{{ $user->id }}';
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/admin/assign',
                    data: { data: data, user: userID },
                    success: function(msg) {
                        console.log(msg);
                    },
                    error: function(msg) {
                        console.log(msg);
                    }
                }); 
                $('#supervisor-field').html('<p class="mb-3 text-secondary"><i class="fas fa-user-friends"></i> <strong>' + $('#supervisor-autocomplete').val() + '</strong> <span style="margin-left: 5px;font-size: 12.5px;cursor: pointer;" class="text-secondary" id="edit-supervisor" onclick="openForm()"><i class="fas fa-pencil-alt"></i></span><span style="margin-left: 10px;vertical-align:middle;cursor: pointer;font-size:12.5px;" onclick="deleteAssign()"><i class="fas fa-times"></i></span></p>');
            } else {
                 alert('Benutzer existiert nicht!');
            }
        }

        function deleteAssign() {
            var userID = '{{ $user->id }}';
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/admin/delete',
                data: { user: userID },
                success: function(msg) {
                    console.log(msg);
                },
                error: function(msg) {
                    console.log(msg);
                }
            }); 
            $('#supervisor-field').html('<p class="mb-3 text-secondary"><span style="margin-left: 5px;font-size: 12.5px;cursor: pointer;" class="text-secondary" id="edit-supervisor" onclick="openForm()"><i class="fas fa-plus" style="color: #17a2b8;"></i> Vorgesetzten hinzufügen</i></span></p>');           
        }
    </script>

@endsection