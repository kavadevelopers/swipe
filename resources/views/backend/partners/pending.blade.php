@extends ('backend.layouts.app')

@section ('title', 'Pending Partner')

@section('page-header')
    <h1>Pending Partner</h1>
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Pending Partner</h3>

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
                            <th>Activation code</th>
                            <th>Approved by</th>
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
            
            var dataTable = $('#partners-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("admin.partners.pending.get") }}',
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
                            if(row.bank_detail){
                                return row.bank_detail.bank_name+"<br>"+row.bank_detail.account_number;
                            }else{
                                return "";
                            }
                        }
                    },
                    {data: 'activation_code', name: '{{config('module.partners.table')}}.activation_code'},
                    {data: 'admin_detail', name: '{{config('module.partners.table')}}.email',
                        render: function ( data, type, row, meta ) {
                            console.log("row.admin_detail ==> ",row.admin_detail);
                            
                            if(row.admin_detail !== null){
                                return row.admin_detail.first_name+" "+row.admin_detail.last_name;
                                
                            }
                        return "";
                    }}
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
