@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.userpricings.management'))

@section('page-header')
    <h1>{{ trans('labels.backend.userpricings.management') }}</h1>
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.backend.userpricings.management') }}</h3>

            <div class="box-tools pull-right">
            </div>
        </div><!--box-header with-border-->

        <div class="box-body">
            <div class="table-responsive data-table-wrapper">
                <table id="userpricings-table" class="table table-condensed table-hover table-bordered">
                    <thead>
                        <tr>
                            <!-- <th>{{ trans('Id') }}</th> -->
                            <th>{{ trans('Vehical Name') }}</th>
                            <th>{{ trans('Price') }}</th>
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
            
            var dataTable = $('#userpricings-table').dataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("admin.userpricings.get") }}',
                    type: 'post'
                },
                columns: [
                    // {data: 'id', name: '{{config('module.userpricings.table')}}.id'},
                    {data: 'vehical_name', name: '{{config('module.userpricings.table')}}.vehical_name'},
                    {data: 'user_price', name: '{{config('module.userpricings.table')}}.user_price'},
                    {data: 'actions', name: 'actions', searchable: false, sortable: false}
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
