@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.vehicles.management'))

@section('page-header')
    <h1>{{ trans('labels.backend.vehicles.management') }}</h1>
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.backend.vehicles.management') }}</h3>

           
        </div><!--box-header with-border-->

        <div class="box-body">
            <div class="table-responsive data-table-wrapper">
                <table id="vehicles-table" class="table table-condensed table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>{{ trans('labels.backend.vehicles.table.id') }}</th>
                            <th>{{ trans('Model Name') }}</th>
                            <th>{{ trans('Brand Name') }}</th>
                            <th>{{ trans('Vehical Type') }}</th>
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
            
            var dataTable = $('#vehicles-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("admin.vehicles.get") }}',
                    type: 'post'
                },
                columns: [
                    {data: 'id', name: '{{config('module.vehicles.table')}}.id'},
                    {data: 'model_name', name: '{{config('module.vehicles.table')}}.model_name'},
                    {data: 'brand_detail', name: '{{config('module.vehicles.table')}}.brand_detail',
                        render: function ( data, type, row, meta ) {
                            return row.brand_detail.brand_name;
                        }
                    },
                    {data: 'vehical_detail', name: '{{config('module.vehicles.table')}}.vehical_detail',
                        render: function ( data, type, row, meta ) {
                            return row.vehical_detail.vehical_name;
                        }
                    },
                    {data: 'actions', name: 'actions', searchable: false, sortable: false}
                ],
                order: [[0, "asc"]],
                searchDelay: 500,
                dom: 'lBfrtip',
                
            });

            Backend.DataTableSearch.init(dataTable);
        });
    </script>
@endsection
