@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.faqs.management'))

@section('page-header')
    <h1>{{ trans('labels.backend.faqs.management') }}</h1>
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">

            @permission('create-faq')
                <a href="{{route('admin.faqs.create')}}">
                    <button type="button" class="btn btn-primary btn-flat">
                        <i class="fa fa-plus"></i> Create New
                    </button>
                </a>
            @endauth
            </h3>
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive data-table-wrapper">
                <table id="faqs-table" class="table table-condensed table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>{{ trans('labels.backend.faqs.table.question') }}</th>
                            <th>{{ trans('labels.backend.faqs.table.answer') }}</th>
                            <th>{{ trans('labels.backend.faqs.table.updatedat') }}</th>
                            <th>{{ trans('labels.general.actions') }}</th>
                        </tr>
                    </thead>
                    
                </table>
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
    </div><!--box-->

    <!--<div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('history.backend.recent_history') }}</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div><!-- /.box tools -->
        </div><!-- /.box-header -->
        <div class="box-body">
            {{-- {!! history()->renderType('Blog') !!} --}}
        </div><!-- /.box-body -->
    </div><!--box box-info-->
@endsection

@section('after-scripts')
    {{-- For DataTables --}}
    {{ Html::script(mix('js/dataTable.js')) }}

    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var dataTable = $('#faqs-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("admin.faqs.get") }}',
                    type: 'post'
                },
                columns: [
                    {data: 'question', name: '{{config('module.faqs.table')}}.question'},
                    {data: 'answer', name: '{{config('module.faqs.table')}}.answer'},
                    {data: 'created_at', name: '{{config('module.faqs.table')}}.created_at'},
                    {data: 'actions', name: 'actions', searchable: false, sortable: false}
                ],
                order: [[1, "asc"]],
                searchDelay: 500,
                dom: 'lBfrtip',
                buttons: {
                    buttons: [
                        { extend: 'copy', className: 'copyButton',  exportOptions: {columns: [ 0, 1, 2, 3]  }},
                        { extend: 'csv', className: 'csvButton',  exportOptions: {columns: [ 0, 1, 2, 3 ]  }},
                        { extend: 'excel', className: 'excelButton',  exportOptions: {columns: [ 0, 1, 2, 3 ]  }},
                        { extend: 'pdf', className: 'pdfButton',  exportOptions: {columns: [ 0, 1, 2, 3 ]  }},
                        { extend: 'print', className: 'printButton',  exportOptions: {columns: [ 0, 1, 2, 3 ]  }}
                    ]
                },
                language: {
                    @lang('datatable.strings')
                }
            });

            Backend.DataTableSearch.init(dataTable);
        });
    </script>
@endsection