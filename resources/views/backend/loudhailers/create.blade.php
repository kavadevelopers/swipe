@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.loudhailers.management') . ' | ' . trans('labels.backend.loudhailers.create'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.loudhailers.management') }}
    </h1>
@endsection

@section('content')
    {{ Form::open(['route' => 'admin.loudhailers.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'create-loudhailer']) }}

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('labels.backend.loudhailers.create') }}</h3>

                <div class="box-tools pull-right">
                    @include('backend.loudhailers.partials.loudhailers-header-buttons')
                </div><!--box-tools pull-right-->
            </div><!--box-header with-border-->

            <div class="box-body">
                <div class="form-group">
                    {{-- Including Form blade file --}}
                    @include("backend.loudhailers.form")
                    <div class="edit-form-btn">
                        {{ link_to_route('admin.loudhailers.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                        {{ Form::submit("Send", ['class' => 'btn btn-primary btn-md']) }}
                        <div class="clearfix"></div>
                    </div><!--edit-form-btn-->
                </div><!-- form-group -->
            </div><!--box-body-->
        </div><!--box box-success-->
    {{ Form::close() }}
@endsection
