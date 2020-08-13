<div class="box-body">
                        <div class="form-group">
                            {{ Form::label('brand_name', trans('Brand Name'), ['class' => 'col-lg-2 control-label required']) }}

                            <div class="col-lg-10">
                            {!! Form::select('brand_id',$brand, null,['class' => 'form-control box-size','placeholder' => 'Select Brand', 'required' => 'required']) !!}
                            @if($errors->has('brand_id'))
                                <div class="alert alert-danger box-size">{{ $errors->first('brand_id') }}</div>
                            @endif
                            </div><!--col-lg-10-->
                        </div><!--form control-->
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            {{ Form::label('type', trans('Vehicle Type'), ['class' => 'col-lg-2 control-label required']) }}

                            <div class="col-lg-10">
                            {!! Form::select('vehicletype_id',$vehicle, null,['class' => 'form-control box-size','placeholder' => 'Select Vehicle', 'required' => 'required']) !!}
                            @if($errors->has('vehicletype_id'))
                                <div class="alert alert-danger box-size">{{ $errors->first('vehicletype_id') }}</div>
                            @endif
                            </div><!--col-lg-10-->
                        </div><!--form control-->
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            {{ Form::label('model_name', trans('Model Name'), ['class' => 'col-lg-2 control-label required']) }}

                            <div class="col-lg-10">
                                {{ Form::text('model_name', null, ['class' => 'form-control box-size', 'placeholder' => trans('Model Name'), 'required' => 'required']) }}
                                @if($errors->has('model_name'))
                                    <div class="alert alert-danger box-size">{{ $errors->first('model_name') }}</div>
                                @endif
                            </div><!--col-lg-10-->
                        </div><!--form control-->
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            {{ Form::label('model_img', trans('Model Image'), ['class' => 'col-lg-2 control-label required']) }}

                            <div class="col-lg-10">
                                {{ Form::file('model_img', null, ['class' => 'form-control box-size', 'placeholder' => trans('model_img'), 'required' => 'required']) }}
                                @if($errors->has('model_img'))
                                    <div class="alert alert-danger box-size">{{ $errors->first('model_img') }}</div>
                                @endif
                            </div><!--col-lg-10-->
                        </div><!--form control-->
                    </div>
                    
@section("after-scripts")
    <script type="text/javascript">
        //Put your javascript needs in here.
        //Don't forget to put `@`parent exactly after `@`section("after-scripts"),
        //if your create or edit blade contains javascript of its own
        $( document ).ready( function() {
            //Everything in here would execute after the DOM is ready to manipulated.
        });
    </script>
@endsection
