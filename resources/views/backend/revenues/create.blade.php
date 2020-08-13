@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.revenues.management') . ' | ' . trans('labels.backend.revenues.create'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.revenues.management') }}
        <small>{{ trans('labels.backend.revenues.create') }}</small>
    </h1>
@endsection

@section('content')
    {{ Form::open(['route' => 'admin.revenues.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'create-revenue']) }}

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('labels.backend.revenues.create') }}</h3>

                <div class="box-tools pull-right">
                    @include('backend.revenues.partials.revenues-header-buttons')
                </div><!--box-tools pull-right-->
            </div><!--box-header with-border-->

            <div class="box-body">
                <div class="form-group">
                    {{-- Including Form blade file --}}
                    @include("backend.revenues.form")
                    <div class="edit-form-btn">
                        {{ link_to_route('admin.revenues.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                        {{ Form::submit(trans('buttons.general.crud.create'), ['class' => 'btn btn-primary btn-md']) }}
                        <div class="clearfix"></div>
                    </div><!--edit-form-btn-->
                </div><!-- form-group -->
            </div><!--box-body-->
        </div><!--box box-success-->
    {{ Form::close() }}
@endsection
