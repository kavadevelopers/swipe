@extends ('backend.layouts.app')

@section ('title', trans('Partner Redemptions'))

@section('page-header')
    <h1>{{ trans('Partner Redemptions') }}</h1>
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('Partner Redemptions') }}</h3>
        </div><!--box-header with-border-->

        <div class="box-body">
            <div class="table-responsive data-table-wrapper">
                <table id="expenditures-table" class="table table-condensed table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>{{ trans('Date/Time') }}</th>
                            <th>{{ trans('Name') }}</th>
                            <th>{{ trans('Delivery Address') }}</th>
                            <th>{{ trans('Status') }}</th>
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
            
            var dataTable = $('#expenditures-table').dataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("admin.expenditures.partnerredemptions") }}',
                    type: 'post'
                },
                columns: [
                    {data: 'date_time', name: '{{config('module.partnerredemptions.table')}}.date_time'},
                    {data: 'name', name: '{{config('module.partnerredemptions.table')}}.name'},
                    {data: 'address', name: '{{config('module.partnerredemptions.table')}}.address'},
                    {data: 'status', name: '{{config('module.partnerredemptions.table')}}.status'},
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
