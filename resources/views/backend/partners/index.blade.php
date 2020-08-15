@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.partners.management'))

@section('page-header')
    <h1>{{ trans('labels.backend.partners.management') }}</h1>
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.backend.partners.management') }}</h3>

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

    <!-- <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script> -->
    <script>
        //Below written line is short form of writing $(document).ready(function() { })
        var dataTable1;
        
        $(document).ready(function(){
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            console.log("data");
            dataTable1 = $('#partners-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("admin.partners.get") }}',
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
                            var detail = "";
                            if(row.bank_detail != null)
                            {

                            detail = row.bank_detail.bank_name+"<br>"+row.bank_detail.account_number;
                            }
                            return detail;
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
                dom: 'lBfrtip'
        });
            
        $(document).on("click", ".washer-status", function () {
            var status = $(this).attr('data-set');    
            var id = $(this).attr('id');
            $.ajax({
                url: "{{ url('admin/partner/status') }}",
                type: "POST",
                data:{
                    "id": id,
                    "status": status,
                },
                beforeSend : function(){
                    $('.full-loader').show();
                },
                success: function(response) {
                    dataTable1.draw();
                    $('.full-loader').hide();
                },
                error: function(error) {
                    // fgcode.val("Please select first FGcode");
                }
            });  
        });

        });
    </script>
@endsection
