@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.partnerfaqs.management'))

@section('page-header')
    <h1>{{ trans('labels.backend.partnerfaqs.management') }}</h1>
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">

                @permission( 'create-partnerfaq' )
                <a href="{{ route( 'admin.partnerfaqs.create' ) }}">
                    <button type="button" class="btn btn-primary btn-flat">
                        <i class="fa fa-plus"></i> Create New
                    </button>
                </a>
                @endauth
            </h3>
        </div><!--box-header with-border-->

        <div class="box-body">
            <div class="table-responsive data-table-wrapper">
                <table id="partnerfaqs-table" class="table table-condensed table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>Question</th>
                            <th>Answer</th>
                            <th>Updated At</th>
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
            
            var dataTable = $('#partnerfaqs-table').dataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("admin.partnerfaqs.get") }}',
                    type: 'post'
                },
                columns: [
                    {data: 'question', name: '{{config('module.partnerfaqs.table')}}.question'},
                    {data: 'answer', name: '{{config('module.partnerfaqs.table')}}.answer'},
                    {data: 'created_at', name: '{{config('module.partnerfaqs.table')}}.created_at'},
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
