@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.partnerredemptions.management'))

@section('page-header')
    <h1>{{ trans('labels.backend.partnerredemptions.management') }}</h1>
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.backend.partnerredemptions.management') }}</h3>

            <div class="box-tools pull-right">
                
              
            </div>
        </div><!--box-header with-border-->

        <div class="box-body">
            <div class="table-responsive data-table-wrapper">
                <table id="partnerredemptions-table" class="table table-condensed table-hover table-bordered">
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
            
            var dataTable = $('#partnerredemptions-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("admin.partnerredemptions.gethistory") }}',
                    type: 'post'
                },
                columns: [
                    {data: 'date_time', name: '{{config('module.partnerredemptions.table')}}.date_time'},
                    {data: 'name', name: '{{config('module.partnerredemptions.table')}}.name'},
                    {data: 'address', name: '{{config('module.partnerredemptions.table')}}.address'},
                    {data: 'status', name: '{{config('module.partnerredemptions.table')}}.status'},
                    // {data: 'actions', name: 'actions', searchable: false, sortable: false}
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

            // Backend.DataTableSearch.init(dataTable);
            
            $(document).on("click", "#generatePdf", function () {
                var val = [];
                $(':checkbox:checked').each(function(i){
                    val[i] = $(this).val();
                });
                
                $.ajax({
                url: "{{ url('admin/partnerredemption/pdf') }}",
                type: "POST",
                data:{
                    "idArr": val,
                },
                success: function(response) {
                    var data = response.data;
                    var trData = "";

                    for(var i=0; i< data.length; i++){
                        console.log(" data == > ",data[i].date_time);
                        
                        trData += "<tr><td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>"+data[i].date_time+"</td><td style='border: 1px solid   #dddddd;text-align: left;padding: 8px;'>"+data[i].name+"</td><td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>"+data[i].address+"</td></tr>";
                    }
                    
                    var divContents = "<h2>Partner Redemption</h2> <table style='font-family: arial, sans-serif;border-collapse: collapse;width: 100%;'> <tr> <th style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Date/Time</th> <th style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Name</th> <th style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Delivery Address</th></tr>"+trData+"</table>";
                    var printWindow = window.open('', '', 'height=400,width=800');
                    printWindow.document.write('<html><head><title>Partner Redemption</title>');
                    printWindow.document.write('</head><body >');
                    printWindow.document.write(divContents);
                    printWindow.document.write('</body></html>');
                    printWindow.print();
                    printWindow.close();
                },
                error: function(error) {
                    // fgcode.val("Please select first FGcode");
                }
            });  
            });
        });
    </script>
@endsection
