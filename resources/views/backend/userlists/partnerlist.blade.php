@extends ('backend.layouts.app')

@section ('title', "Partners ".trans('labels.backend.userlists.management'))

@section('page-header')
    <h1>Partners {{ trans('labels.backend.userlists.management') }}</h1>
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Partners {{ trans('labels.backend.userlists.management') }}</h3>

           
        </div><!--box-header with-border-->

        <div class="box-body">
            <div class="table-responsive data-table-wrapper">
                <table id="partnerlists-table" class="table table-condensed table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>{{ trans('Index') }}</th>
                            <th>{{ trans('labels.backend.userlists.table.name') }}</th>
                            <th>{{ trans('labels.backend.userlists.table.os') }}</th>
                            <th>{{ trans('labels.backend.userlists.table.mobile') }}</th>
                            <th>{{ trans('labels.backend.userlists.table.email') }}</th>
                            <th>{{ trans('labels.backend.userlists.table.registered_since') }}</th>
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

            var dataTable = $('#partnerlists-table').dataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("admin.partnerlists.get") }}',
                    type: 'post'
                },
                columns: [
                    {   
                        data: 'id', 
                        name: '{{config('module.userlists.table')}}.id',
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {data: 'name', name: '{{config('module.userlists.table')}}.name'},
                    {data: 'device_type', name: '{{config('module.userlists.table')}}.device_type'},
                    {data: 'mobile', name: '{{config('module.userlists.table')}}.mobile'},
                    {data: 'email', name: '{{config('module.userlists.table')}}.email'},
                    {data: 'created_at', name: '{{config('module.userlists.table')}}.created_at'},
                    {
                        data: null,
                        name: 'actions',
                        searchable: false,
                        sortable: false,
                        render: (data, type, row, meta) => {
                            let activitiesUrl = "{{ route( 'admin.partnerlists.activities', ':partnerlist' ) }}".replace(':partnerlist', data.id);
                            let str = "";
                            str += `<a href="${activitiesUrl}" class="btn btn-primary btn-flat">{{ trans( 'menus.backend.userlists.activities' ) }}</a>`;
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
