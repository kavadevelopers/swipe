@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.vehicles.management'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.vehicles.management') }}
        
    </h1>
@endsection

@section('content')
    {{ Form::model($vehicles, ['route' => ['admin.vehicles.update', $vehicles], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH', 'id' => 'edit-vehicle',  'enctype' => 'multipart/form-data']) }}

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('labels.backend.vehicles.edit') }}</h3>

               
            </div><!--box-header with-border-->

            <div class="box-body">
                <div class="form-group">
                    {{-- Including Form blade file --}}
                    @include("backend.vehicles.form")
                    <div class="edit-form-btn">
                        {{ link_to_route('admin.vehicles.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                        {{ Form::submit(trans('buttons.general.crud.update'), ['class' => 'btn btn-primary btn-md']) }}
                        <div class="clearfix"></div>
                    </div><!--edit-form-btn-->
                </div><!--form-group-->
            </div><!--box-body-->
        </div><!--box box-success -->
    {{ Form::close() }}
@endsection
