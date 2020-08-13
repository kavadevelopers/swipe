@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.partnerpricings.management') . ' | ' . trans('labels.backend.partnerpricings.edit'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.partnerpricings.management') }}
        <small>{{ trans('labels.backend.partnerpricings.edit') }}</small>
    </h1>
@endsection

@section('content')
    {{ Form::model($partnerpricings, ['route' => ['admin.partnerpricings.update', $partnerpricings], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH', 'id' => 'edit-partnerpricing']) }}

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('labels.backend.partnerpricings.edit') }}</h3>

                
            </div><!--box-header with-border-->

            <div class="box-body">
                <div class="form-group">
                    {{-- Including Form blade file --}}
                    @include("backend.partnerpricings.form")
                    <div class="edit-form-btn">
                        {{ link_to_route('admin.partnerpricings.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                        {{ Form::submit(trans('buttons.general.crud.update'), ['class' => 'btn btn-primary btn-md']) }}
                        <div class="clearfix"></div>
                    </div><!--edit-form-btn-->
                </div><!--form-group-->
            </div><!--box-body-->
        </div><!--box box-success -->
    {{ Form::close() }}
@endsection
