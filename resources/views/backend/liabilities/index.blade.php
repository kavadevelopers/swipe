@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.liabilities.management'))

@section('page-header')
    <h1>Partenere Earning</h1>
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Partenere Earning</h3>

             <div class="box-tools pull-right">
             {{ Form::label('start_date', trans('validation.attributes.backend.promocodes.start_date'), ['class' => 'col-lg-2 control-label required']) }}
             <div class="col-lg-10">
                {{ Form::date('end_date', null, ['class' => 'form-control col-lg-9', 'id' =>'startDate', 'placeholder' => trans('validation.attributes.backend.promocodes.end_date')]) }}
            </div>
             {{ Form::label('end_date', trans('validation.attributes.backend.promocodes.end_date'), ['class' => 'col-lg-2 control-label required']) }}
             <div class="col-lg-10">
                {{ Form::date('end_date', null, ['class' => 'form-control col-lg-9', 'id' =>'endDate', 'placeholder' => trans('validation.attributes.backend.promocodes.end_date')]) }}
                </div>
            <button type="button" class="btn btn-primary btn-flat pull-right" id="generate">{{ trans( 'Generate' ) }}</a>
            </div>
        </div><!--box-header with-border-->

        <div class="box-body">
            <div class="table-responsive data-table-wrapper">
                <table id="liabilities-table" class="table table-condensed table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>{{ trans('Name') }}</th>
                            <th>{{ trans('Email') }}</th>
                            <th>{{ trans('Contact') }}</th>
                            <th>{{ trans('Total Earn') }}</th>
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
            
            var dataTable = $('#liabilities-table').dataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("admin.liabilities.get") }}',
                    type: 'post'
                },
                columns: [
                    {data: 'name', name: '{{config('module.booking.table')}}.name'},
                    {data: 'email', name: '{{config('module.booking.table')}}.email'},
                    {data: 'mobile', name: '{{config('module.booking.table')}}.mobile'},
                    {data: 'total_earn', name: '{{config('module.booking.table')}}.total_earn'},
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

        $(document).on("click", "#generate", function(){
            var startDate = $("#startDate").val();
            var endDate = $("#endDate").val();
            if(startDate == "" || endDate == "")
            {
                alert("pleser select startDate and Enddate.");
            }else{
               
                $.ajax({
                url: "{{ url('admin/liabilities/getbankdetail') }}",
                type: "POST",
                data:{
                    "startDate": startDate,
                    "endDate": endDate,
                },
                success: function(response) {
                    var data = response.data;
                    var trData = "";
                    for(var i=0; i< data.length; i++){
                        trData += "<tr><td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>"+data[i].name+"</td><td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>"+data[i].mobile+"</td><td style='border: 1px solid   #dddddd;text-align: left;padding: 8px;'>"+data[i].total_earn+"</td><td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>"+data[i].bank_detail.bank_name+"</td><td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>"+data[i].bank_detail.account_number+"</td></tr>";
                    }
                    
                    var divContents = "<h2>Partner Bankdetail</h2> <table style='font-family: arial, sans-serif;border-collapse: collapse;width: 100%;'> <tr> <th style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Partner Name</th> <th style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Contact No</th>  <th style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Amount</th> <th style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>BankName</th><th style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>BankAccount</th></tr>"+trData+"</table>";
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
            }
            
            
        });
    </script>
@endsection
