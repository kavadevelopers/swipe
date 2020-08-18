@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.promocodes.management'))

@section('page-header')
    <h1>{{ trans('labels.backend.promocodes.management') }}</h1>
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            @permission( 'create-promocode' )
                <a href="{{ route( 'admin.promocodes.create' ) }}" class="btn btn-primary btn-flat">
                    <i class="fa fa-plus"></i> {{ trans( 'menus.backend.promocodes.create' ) }}
                </a>
            @endauth

            <div class="box-tools pull-right">
                
            </div>
        </div><!--box-header with-border-->

        <div class="box-body">
            <div class="table-responsive data-table-wrapper">
                <table id="promocodes-table" class="table table-condensed table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>{{ trans('labels.backend.promocodes.table.id') }}</th>
                            <th>{{ trans('labels.backend.promocodes.table.createdat') }}</th>
                            <th>{{ trans('labels.backend.promocodes.table.promo_code') }}</th>
                            <th>{{ trans('labels.backend.promocodes.table.count_limit') }}</th>
                            <th>{{ trans('labels.backend.promocodes.table.time_limit') }}</th>
                            <th>{{ trans('labels.backend.promocodes.table.status') }}</th>
                            <th>{{ trans('labels.backend.promocodes.table.createdBy') }}</th>
                            <th>Active</th>
                        </tr>
                    </thead>
                   
                </table>
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
    </div><!--box-->
@endsection

@section('after-scripts')
    {{-- For DataTables --}}
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    {{ Html::script(mix('js/dataTable.js')) }}
    <script>
        //Below written line is short form of writing $(document).ready(function() { })
        var dataTable = "";
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            dataTable = $('#promocodes-table').DataTable({
                fnDrawCallback: function() {
                    $('.promo-status').bootstrapToggle();
                },
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("admin.promocodes.get") }}',
                    type: 'post'
                },
                columns: [
                    {data: 'id', name: '{{config('module.promocodes.table')}}.id'},
                    {data: 'created_at', name: '{{config('module.promocodes.table')}}.created_at'},
                    {data: 'promo_code', name: '{{config('module.promocodes.table')}}.promo_code'},
                    {data: 'count_limit', name: '{{config('module.promocodes.table')}}.count_limit'},
                    {data: 'time_limit', name: '{{config('module.promocodes.table')}}.time_limit'},
                    {
                        data: 'status',
                        name: '{{config('module.promocodes.table')}}.status',
                        render: (status) => {
                            return (status == 1) ? "Live" : "Expired";
                        }
                    },
                    {data: 'createdBy', name: '{{config('module.promocodes.table')}}.createdBy'},
                    {
                        data: null,
                        name: 'actions',
                        searchable: false,
                        sortable: false,
                        render: (data, type, row, meta) => {
                            let str = "";
                            str += `<input type="checkbox" data-toggle="toggle" class="promo-status" data-promo-id=${data.id} ${(data.status == 1) ? "checked" : ""}  data-on="1" data-off="0" />`;
                            
                            return str;
                        }
                    }
                ],
                order: [[0, "asc"]],
                searchDelay: 500,
                dom: 'lBfrtip',
                buttons: {
                    buttons: [
                        { extend: 'copy', className: 'copyButton',  exportOptions: {columns: [ 0, 1, 2 ]  }},
                        { extend: 'csv', className: 'csvButton',  exportOptions: {columns: [ 0, 1, 2 ]  }},
                        { extend: 'excel', className: 'excelButton',  exportOptions: {columns: [ 0, 1, 2 ]  }},
                        { extend: 'pdf', className: 'pdfButton',  exportOptions: {columns: [ 0, 1, 2 ]  }},
                        { extend: 'print', className: 'printButton',  exportOptions: {columns: [ 0, 1, 2 ]  }}
                    ]
                },
                drawCallback: function( settings, json ) {
                    let activePromo = $.grep( settings.aoData, function( n, i ) {
                        return n._aData.status == 1;
                    });

                    let checked = (activePromo.length == 0);
                    $("#disableAll").prop("checked", checked);
                }
            });

            Backend.DataTableSearch.init(dataTable);

        });

        $(document).on("change", ".promo-status", function(e) {
            let id = $(this).data('promo-id');
            let status = 1;
            if($(this).prop("checked")){
                status = 1;
            }else{
                status = 0;
            }
            $.ajax({
                url: "{{ url('admin/promocodes/status') }}",
                type: "POST",
                data:{
                    "id": id,
                    "status": status,
                },
                beforeSend : function(){
                    $('.full-loader').show();
                },
                success: function(response) {
                    dataTable.draw();
                    $('.full-loader').hide();
                },
                error: function(error) {
                    // fgcode.val("Please select first FGcode");
                }
            });
        });
    </script>
@endsection
