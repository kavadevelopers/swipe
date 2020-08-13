@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.userpricings.management') . ' | ' . trans('labels.backend.userpricings.edit'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.userpricings.management') }}
        <small>{{ trans('labels.backend.userpricings.edit') }}</small>
    </h1>
@endsection

@section('content')
    {{ Form::model($userpricings, ['route' => ['admin.userpricings.update', $userpricings], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH', 'id' => 'edit-userpricing']) }}

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('labels.backend.userpricings.edit') }}</h3>

               
            </div><!--box-header with-border-->

            <div class="box-body">
                <div class="form-group">
                    {{-- Including Form blade file --}}
                    @include("backend.userpricings.form")
                    <div class="edit-form-btn">
                        {{ link_to_route('admin.userpricings.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                        {{ Form::submit(trans('buttons.general.crud.update'), [ 'class' => 'btn btn-primary btn-md']) }}
                        <div class="clearfix"></div>
                    </div><!--edit-form-btn-->
                </div><!--form-group-->
            </div><!--box-body-->
        </div><!--box box-success -->
    {{ Form::close() }}
@endsection
