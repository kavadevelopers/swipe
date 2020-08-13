@extends('backend.layouts.app')

@section('page-header')
    <h1>
        <span>Swipe</span>
        <small>{{ trans('strings.backend.dashboard.title') }}</small>
    </h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="mini-stat clearfix bg-calculator rounded">
                <span class="mini-stat-icon"><i class="fa fa-users fg-calculator"></i></span>
                <div class="mini-stat-info">
                    <span>Users - {{ $users['total'] }}</span>
                </div>
                <ul class="mini-stat-info-count">
                    @foreach($users as $key => $count)
                        <li>{{ $key }} - <span>{{ $count }}</span></li>
                    @endforeach
                </ul>
            </div>           
        </div>

        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="mini-stat clearfix bg-calculator rounded">
                <span class="mini-stat-icon"><i class="fa fa-users fg-calculator"></i></span>
                <div class="mini-stat-info">
                    <span>Partners - {{ $partners['total'] }}</span>
                </div>
                <ul class="mini-stat-info-count">
                    @foreach($partners as $key => $count)
                        <li>{{ $key }} - <span>{{ $count }}</span></li>
                    @endforeach
                </ul>
            </div>           
        </div>

        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="mini-stat clearfix bg-calculator rounded">
                <span class="mini-stat-icon"><i class="fa fa-ticket fg-calculator"></i></span>
                <div class="mini-stat-info">
                    <span>Bookings - {{ $bookings['total'] }}</span>
                </div>
                <ul class="mini-stat-info-count">
                    @foreach($bookings as $key => $count)
                        <li>{{ $key }} - <span>{{ $count }}</span></li>
                    @endforeach
                </ul>
            </div>           
        </div>
    </div>
@endsection