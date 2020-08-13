@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.policies.management') . ' | ' . trans('labels.backend.policies.edit'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.policies.management') }}
    </h1>
@endsection

@section('content')
    {{ Form::model($policies, ['route' => ['admin.policies.update', $policies], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH', 'id' => 'edit-policy']) }}

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ "Edit $policies->title" }}</h3>

                <div class="box-tools pull-right">

                </div><!--box-tools pull-right-->
            </div><!--box-header with-border-->

            <div class="box-body">
                <div class="form-group">
                    {{-- Including Form blade file --}}
                    @include("backend.policies.form")
                    <div class="edit-form-btn">
                        {{ link_to_route('admin.policies.show', trans('buttons.general.cancel'), ['policy' => $policies], ['class' => 'btn btn-danger btn-md']) }}
                        {{ Form::submit(trans('buttons.general.crud.update'), ['class' => 'btn btn-primary btn-md']) }}
                        <div class="clearfix"></div>
                    </div><!--edit-form-btn-->
                </div><!--form-group-->
            </div><!--box-body-->
        </div><!--box box-success -->
    {{ Form::close() }}
@endsection
