@extends ('backend.layouts.app')

@section ('title', "User ".trans('labels.backend.userlists.activities'))

@section('page-header')
    <h1>User {{ trans('labels.backend.userlists.activities') }}</h1>
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">User {{ trans('labels.backend.userlists.activities') }}</h3>

            <div class="box-tools pull-right">
                <a href="{{ route( 'admin.userlists.index' ) }}" class="btn btn-primary btn-flat">{{ trans( 'menus.backend.userlists.all' ) }}</a>
                @include('backend.userlists.partials.userlists-header-buttons')
            </div>
        </div><!--box-header with-border-->

        <div class="box-body">
            <div class="table-responsive data-table-wrapper">
                <table id="user-activity-table" class="table table-condensed table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>{{ trans('labels.backend.userlists.activity-table.date') }}</th>
                            <th>{{ trans('labels.backend.userlists.activity-table.time') }}</th>
                            <th>{{ trans('labels.backend.userlists.activity-table.booking_id') }}</th>
                            <th>{{ trans('labels.backend.userlists.activity-table.accepted_by') }}</th>
                            <th>{{ trans('labels.backend.userlists.activity-table.booking_location') }}</th>
                            <th>{{ trans('labels.backend.userlists.activity-table.booking_duration') }}</th>
                            <th>{{ trans('labels.backend.userlists.activity-table.service_type') }}</th>
                            <th>{{ trans('labels.backend.userlists.activity-table.service_fee') }}</th>
                            <th>{{ trans('labels.backend.userlists.activity-table.status') }}</th>
                            <th>{{ trans('labels.general.actions') }}</th>
                        </tr>
                    </thead>
                    
                </table>
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
    </div><!--box-->
@endsection

@section('after-scripts')
    {{-- For DataTables --}}
    {{ Html::script(mix('js/dataTable.js')) }}

    <script>
        //Below written line is short form of writing $(document).ready(function() { })
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var dataTable = $('#user-activity-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("admin.userlists.get-activities", $user->id) }}',
                    type: 'post'
                },
                columns: [
                    {data: 'bookingDate', name: 'bookingDate',searchable: false},
                    {data: 'bookingTime', name: 'bookingTime',searchable: false},
                    {data: 'id', name: 'id'},
                    {data: 'washername', name: 'washername'},
                    {data: 'location', name: 'location',searchable: false},
                    {data: 'duration', name: 'duration',searchable: false},
                    {data: 'vehical_name', name: 'vehical_name'},
                    {data: 'fare', name: 'fare'},
                    {data: 'status', name: 'status',searchable: false},
                    {
                        data: null,
                        searchable: false,
                        sortable: false,
                        render: (data, type, row, meta) => {
                            let str = "";
                            if (data.status == "Pending") {
                                str += `<button class="btn btn-primary btn-flat cancel-booking" data-id="${data.id}">Cancel</button>`;
                            } else {
                                str += (data.cancel_by) ? data.cancel_by : "";
                            }
                            return str;
                        }
                    }
                ],
                order: [[0, "asc"]],
                searchDelay: 500,
                dom: 'lBfrtip',
                buttons: {
                    buttons: [
                        { extend: 'copy', className: 'copyButton',  exportOptions: {columns: [ 0, 1 ]  }},
                        { extend: 'csv', className: 'csvButton',  exportOptions: {columns: [ 0, 1 ]  }},
                        { extend: 'excel', className: 'excelButton',  exportOptions: {columns: [ 0, 1 ]  }},
                        { extend: 'pdf', className: 'pdfButton',  exportOptions: {columns: [ 0, 1 ]  }},
                        { extend: 'print', className: 'printButton',  exportOptions: {columns: [ 0, 1 ]  }}
                    ]
                }
            });

            Backend.DataTableSearch.init(dataTable);

            $(document).on('click', '.cancel-booking', function() {
                if(confirm("Are you sure you want to cancel this?")) {
                    var bookingId = $(this).data('id');
                    let cancelBookingUrl = "{{ route( 'admin.userlists.activity.cancel', ':bookingId' ) }}".replace(':bookingId', bookingId);

                    $.ajax({
                        url: cancelBookingUrl,
                        type: "PUT",
                        success: function(response) {
                            dataTable.draw();
                        },
                        error: function(error) {
                            // fgcode.val("Please select first FGcode");
                        }
                    });
                }
            });
        });
    </script>
@endsection
