@extends('layout.app')

@section('title', 'Stundenverwaltung')

@section('content')
    <div class="custom-header">
        <h3>Stundenverwaltung <a href="{{ route('admin.hpd.create') }}" class="badge badge-success" style="font-size: 12px;"><i class="fa fa-plus"></i> Neuer Eintrag</a></h3>
    </div>
    <span class="text-secondary">Administrator Panel <i class="fa fa-angle-right"></i> Stundenverwaltung</span>

    <div class="mt-4 mb-4 p-3 bg-white border shadow-sm lh-sm">
        <!--Order Listing-->
        <div class="product-list">
            {{-- <div class="row border-bottom mb-4">
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
                        </div>

                </div>
                <div class="col-sm-4 text-right pb-3">
                    <div class="clearfix"></div>
                </div>
            </div> --}}
            <div class="table-responsive product-list">
                
                <table class="table table-striped table-bordered dataTable" id="productList" role="grid">
                    <thead>
                        <tr role="row">
                            <th>Eintrag #</th>
                            <th>Name</th>
                            <th>Von</th>
                            <th>Bis</th>
                            <th>Stunden pro Woche</th>
                            <th>Aktion</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($entries as $entry)
                            <tr>
                                <td>{{ $entry->id }}</td>
                                <td>{{ $entry->user_name }}</td>
                                <td>{{ $entry->date_from->format('d.m.Y') }}</td>
                                <td>{{ $entry->date_to->format('d.m.Y') }}</td>
                                <td>{{ $entry->hours_per_week }}h</td>
                                <td class="align-middle text-center">
                                    <a href="{{ route('admin.hpd.edit', $entry->id) }}">
                                        <button class="btn btn-success" data-toggle="modal" data-target="#orderUpdate">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                    </a>
                                    <form action="{{ route('admin.hpd.destroy', $entry->id) }}" method="post" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>

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
        var oTable = $('#productList').DataTable({
            "lengthChange": false,
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
