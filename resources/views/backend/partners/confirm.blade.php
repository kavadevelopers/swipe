@extends ('backend.layouts.app')

@section ('title', 'Confirm Partners')

@section('page-header')
    <h1>Confirm Partners</h1>
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Confirm Partners</h3>

            <div class="box-tools pull-right">
                
            </div>
        </div><!--box-header with-border-->

        <div class="box-body">
            <div class="table-responsive data-table-wrapper">
                <table id="partners-table" class="table table-condensed table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>Date/Time</th>
                            <th>OS</th>
                            <th>Name</th>
                            <th>Contact No.</th>
                            <th>Email Address</th>
                            <th>Citizenship</th>
                            <th>Date of Birth (DOB)</th>
                            <th>Bank Details</th>
                            <th>Reject / Approve</th>
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
            
            var dataTable = $('#partners-table').dataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("admin.partners.confirm.get") }}',
                    type: 'post'
                },
                columns: [
                    {data: 'created_at', name: '{{config('module.partners.table')}}.created_at'},
                    {data: 'device_type', name: '{{config('module.partners.table')}}.device_type'},
                    {data: 'name', name: '{{config('module.partners.table')}}.name'},
                    {data: 'mobile', name: '{{config('module.partners.table')}}.mobile'},
                    {data: 'email', name: '{{config('module.partners.table')}}.email'},
                    {data: 'citizenship', name: '{{config('module.partners.table')}}.citizenship'},
                    {data: 'dob', name: '{{config('module.partners.table')}}.dob'},
                    {data: 'bank_detail', name: '{{config('module.partners.table')}}.email',
                        render: function ( data, type, row, meta ) {
                            return row.bank_detail.bank_name+"<br>"+row.bank_detail.account_number;
                        }
                    },
                    {data: 'actions', name: 'actions', searchable: false, sortable: false,
                        render: function ( data, type, row, meta ) {
                            var button = "<button type='button' id="+row.id+" data-set='Approve' class='washer-status'> Approve </button> <button type='button' id="+row.id+" data-set='Reject' class='washer-status'> Reject </button>";
                            return button;
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
