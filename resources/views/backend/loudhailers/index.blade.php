@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.loudhailers.management'))

@section('page-header')
    <h1>{{ trans('labels.backend.loudhailers.management') }}</h1>
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Notification History</h3>

            <div class="box-tools pull-right">
                @include('backend.loudhailers.partials.loudhailers-header-buttons')
            </div>
        </div><!--box-header with-border-->

        <div class="box-body">
            <div class="table-responsive data-table-wrapper">
                <table id="loudhailers-table" class="table table-condensed table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>{{ trans('labels.backend.loudhailers.table.id') }}</th>
                            <th>{{ trans('labels.backend.loudhailers.table.createdat') }}</th>
                            <th>{{ trans('labels.backend.loudhailers.table.send_by') }}</th>
                            <th>{{ trans('labels.backend.loudhailers.table.title') }}</th>
                            <th>{{ trans('labels.backend.loudhailers.table.message') }}</th>
                        </tr>
                    </thead>
                    <thead class="transparent-bg">
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
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

            var dataTable = $('#loudhailers-table').dataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("admin.loudhailers.get") }}',
                    type: 'post'
                },
                columns: [
                    {data: 'id', name: '{{config('module.loudhailers.table')}}.id'},
                    {data: 'created_at', name: '{{config('module.loudhailers.table')}}.created_at'},
                    {data: 'sendBy', name: '{{config('module.loudhailers.table')}}.sendBy'},
                    {data: 'title', name: '{{config('module.loudhailers.table')}}.title'},
                    {data: 'message', name: '{{config('module.loudhailers.table')}}.message'}
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
