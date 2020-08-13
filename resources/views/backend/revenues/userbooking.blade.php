@extends ('backend.layouts.app')

@section ('title', trans('User Booking'))

@section('page-header')
    <h1>{{ trans('User Booking') }}</h1>
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('User Booking') }}</h3>

            <div class="box-tools pull-right">
                <h4>Total Amount per Day :- {{ $bookingAmount }}</h4>
            </div>
        </div><!--box-header with-border-->

        <div class="box-body">
            <div class="table-responsive data-table-wrapper">
                <table id="revenues-table" class="table table-condensed table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>{{ trans('Booking Id') }}</th>
                            <th>{{ trans('Name') }}</th>
                            <th>{{ trans('Date') }}</th>
                            <th>{{ trans('Amount') }}</th>
                            <th>{{ trans('Action') }}</th>
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
            
            var dataTable = $('#revenues-table').dataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("admin.revenues.getbooking") }}',
                    type: 'post'
                },
                columns: [
                    {   
                        data: 'id', 
                        name: '{{config('module.userlists.table')}}.id',
                        // render: function (data, type, row, meta) {
                        //     return meta.row + meta.settings._iDisplayStart + 1;
                        // }
                    },
                    {
                        data: 'user_detail.name', 
                        name: '{{config('module.revenues.table')}}.name',
                        // render: function (data, type, row, meta) {
                        //     return meta.row + meta.settings._iDisplayStart + 1;
                        // }
                    },
                    {data: 'bookingDate', name: '{{config('module.revenues.table')}}.bookingDate'},
                    {data: 'fare', name: '{{config('module.revenues.table')}}.fare'},
                    {data: null, name: 'actions', searchable: false, sortable: false,
                        render: (data, type, row, meta) => {
                            let str = '<a href="{{ url("admin/revenues/viewuserbooking")}}/'+row.id+'" class="btn btn-flat btn-default"><i data-toggle="tooltip" data-placement="top" title="View" class="fa fa-eye"></i></a>';
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
        });
    </script>
@endsection
