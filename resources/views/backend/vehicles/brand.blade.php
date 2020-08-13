@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.vehicles.management'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.vehicles.management') }}
    </h1>
@endsection

@section('content')
    {{ Form::open(['route' => 'admin.brand.create', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'create-vehicle', 'enctype' => 'multipart/form-data']) }}

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Add Brand</h3>

                <div class="box-tools pull-right">
                    
                </div><!--box-tools pull-right-->
            </div><!--box-header with-border-->

            <div class="box-body">
                <div class="form-group">
                    {{-- Including Form blade file --}}
                    <div class="box-body">
                        <div class="form-group">
                            {{ Form::label('brand_name', trans('Brand'), ['class' => 'col-lg-2 control-label required']) }}

                            <div class="col-lg-10">
                                {{ Form::text('brand_name', null, ['class' => 'form-control box-size', 'placeholder' => trans('Brand'), 'required' => 'required']) }}
                                @if($errors->has('brand_name'))
                                    <div class="alert alert-danger box-size">{{ $errors->first('brand_name') }}</div>
                                @endif
                            </div><!--col-lg-10-->
                        </div><!--form control-->
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            {{ Form::label('brand_image', trans('Brand Image'), ['class' => 'col-lg-2 control-label required']) }}

                            <div class="col-lg-10">
                                {{ Form::file('brand_img', null, ['class' => 'form-control box-size', 'placeholder' => trans('Brand'), 'required' => 'required']) }}
                                @if($errors->has('brand_img'))
                                    <div class="alert alert-danger box-size">{{ $errors->first('brand_img') }}</div>
                                @endif
                            </div><!--col-lg-10-->
                        </div><!--form control-->
                    </div>
                    <div class="edit-form-btn">
                        {{ link_to_route('admin.vehicles.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                        {{ Form::submit(trans('buttons.general.crud.create'), ['class' => 'btn btn-primary btn-md']) }}
                        <div class="clearfix"></div>
                    </div><!--edit-form-btn-->
                </div><!-- form-group -->
            </div><!--box-body-->
        </div><!--box box-success-->
    {{ Form::close() }}
@endsection
