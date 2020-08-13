@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.policies.management'))

@section('page-header')
    <h1>{{ trans('labels.backend.policies.management') }}</h1>
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ $policy->title }}</h3>

            <div class="box-tools pull-right">
                <a href="{{ route('admin.policies.edit', $policy->id) }}" class="btn btn-primary btn-flat">Edit</a>
            </div>
        </div><!--box-header with-border-->

        <div class="box-body">
            <div class="table-responsive data-table-wrapper">
            {!! $policy->content !!}
            </div>
        </div><!-- /.box-body -->
    </div><!--box-->
@endsection

@section('after-scripts')
    <script>
        //Below written line is short form of writing $(document).ready(function() { })
        $(function() {

        });
    </script>
@endsection
