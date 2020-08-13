@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.access.users.management') . ' | ' . trans('labels.backend.access.users.view'))

@section('page-header')
    <h1>
        Booking Detail
        
    </h1>
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">View Booking</h3>

            <div class="box-tools pull-right">
                @include('backend.access.includes.partials.user-header-buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">

            <div role="tabpanel">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#overview" aria-controls="overview" role="tab" data-toggle="tab">Booking Details</a>
                    </li>

                    <!-- <li role="presentation">
                        <a href="#history" aria-controls="history" role="tab" data-toggle="tab">{{ trans('labels.backend.access.users.tabs.titles.history') }}</a>
                    </li> -->
                </ul>

                <div class="tab-content">

                    <div role="tabpanel" class="tab-pane mt-30 active" id="overview">
                    <table class="table table-striped table-hover">
                        <tr>
                            <th>Partener ID</th>
                            <td>{{ $partener->id }}</td>
                        </tr>

                        

                       
                    </table>
                    </div><!--tab overview profile-->

                   
                    <!--tab panel history-->

                </div><!--tab content-->

            </div><!--tab panel-->

        </div><!-- /.box-body -->
    </div><!--box-->
@endsection