@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.access.users.management'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.access.users.management') }}
        <small>{{ trans('labels.backend.access.users.active') }}</small>
    </h1>
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">

            @permission('create-user')
                <a href="{{route('admin.access.user.create')}}">
                    <button type="button" class="btn btn-primary btn-flat">
                        <i class="fa fa-plus"></i> Create New
                    </button>
                </a>
            @endauth
            </h3>

            <div class="box-tools pull-right">
                @include('backend.access.includes.partials.user-header-buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive data-table-wrapper">
                <table id="users-table" class="table table-condensed table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Designation</th>
                            <th>Contact No.</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Since</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <!-- <thead class="transparent-bg">
                        <tr>
                            <th>
                                {!! Form::text('first_name', null, ["class" => "search-input-text form-control", "data-column" => 0, "placeholder" => trans('labels.backend.access.users.table.first_name')]) !!}
                                    <a class="reset-data" href="javascript:void(0)"><i class="fa fa-times"></i></a>
                                </th>
                            <th>
                                {!! Form::text('last_name', null, ["class" => "search-input-text form-control", "data-column" => 1, "placeholder" => trans('labels.backend.access.users.table.last_name')]) !!}
                                    <a class="reset-data" href="javascript:void(0)"><i class="fa fa-times"></i></a>
                            </th>
                            <th>
                                {!! Form::text('user_name', null, ["class" => "search-input-text form-control", "data-column" => 2, "placeholder" => trans('labels.backend.access.users.table.user_name')]) !!}
                                    <a class="reset-data" href="javascript:void(0)"><i class="fa fa-times"></i></a>
                            </th>
                            <th>
                                {!! Form::text('email', null, ["class" => "search-input-text form-control", "data-column" => 3, "placeholder" => trans('labels.backend.access.users.table.email')]) !!}
                                    <a class="reset-data" href="javascript:void(0)"><i class="fa fa-times"></i></a>
                            </th>
                            <th></th>
                            <th>
                            {!! Form::text('roles', null, ["class" => "search-input-text form-control", "data-column" => 4, "placeholder" => trans('labels.backend.access.users.table.roles')]) !!}
                                <a class="reset-data" href="javascript:void(0)"><i class="fa fa-times"></i></a>
                            </th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead> -->
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
            {{-- {!! history()->renderType('User') !!} --}}
        </div><!-- /.box-body -->
    </div><!--box box-info-->
@endsection

@section('after-scripts')
    {{-- For DataTables --}}
    {{ Html::script(mix('js/dataTable.js')) }}

    <script>
        (function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            
            var dataTable = $('#users-table').dataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("admin.access.user.get") }}',
                    type: 'post',
                    data: {status: 1, trashed: false}
                },
                columns: [

                    {data: 'id', name: '{{config('access.users_table')}}.id'},
                    {data: 'first_name', name: '{{config('access.users_table')}}.first_name'},
                    {data: 'designation', name: '{{config('access.users_table')}}.designation'},
                    {data: 'contact_no', name: 'contact_no'},
                    {data: 'email', name: '{{config('access.roles_table')}}.email'},
                    {data: 'status_on', name: '{{config('access.users_table')}}.status',
                         "render": function(data, type, row, meta) {
                            if(row.status_on)
                            return "online";
                            return "offline"
                        }},
                    {data: 'created_at', name: '{{config('access.users_table')}}.created_at'},
                    {data: 'actions', name: 'actions', searchable: false, sortable: false}
                ],
                order: [[0, "asc"]],
                searchDelay: 500,
                dom: 'lBfrtip',
                buttons: {
                    buttons: [
                        { extend: 'copy', className: 'copyButton',  exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6]  }},
                        { extend: 'csv', className: 'csvButton',  exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6]  }},
                        { extend: 'excel', className: 'excelButton',  exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6]  }},
                        { extend: 'pdf', className: 'pdfButton',  exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6]  }},
                        { extend: 'print', className: 'printButton',  exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6]  }}
                    ]
                },
                language: {
                    @lang('datatable.strings')
                }
            });

            Backend.DataTableSearch.init(dataTable);
        })();
    </script>
@endsection