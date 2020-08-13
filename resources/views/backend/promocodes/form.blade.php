<div class="box-body">

    <div class="form-group">
        {{ Form::label('promo_code', trans('validation.attributes.backend.promocodes.promo_code'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
            {{ Form::text('promo_code', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.promocodes.promo_code')]) }}
            @if($errors->has('promo_code'))
                <div class="alert alert-danger box-size">{{ $errors->first('promo_code') }}</div>
            @endif
        </div><!--col-lg-10-->
    </div><!--form control-->
    <div class="form-group">
        {{ Form::label('count_limit', trans('validation.attributes.backend.promocodes.count_limit'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
            {{ Form::number('count_limit', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.promocodes.count_limit')]) }}
            @if($errors->has('count_limit'))
                <div class="alert alert-danger box-size">{{ $errors->first('count_limit') }}</div>
            @endif
        </div><!--col-lg-10-->
    </div><!--form control-->
    <div class="form-group">
        {{ Form::label('start_date', trans('validation.attributes.backend.promocodes.start_date'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
            {{ Form::date('start_date', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.promocodes.start_date')]) }}
            @if($errors->has('start_date'))
                <div class="alert alert-danger box-size">{{ $errors->first('start_date') }}</div>
            @endif
        </div><!--col-lg-10-->
    </div><!--form control-->
    <div class="form-group">
        {{ Form::label('end_date', trans('validation.attributes.backend.promocodes.end_date'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
            {{ Form::date('end_date', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.promocodes.end_date')]) }}
            @if($errors->has('end_date'))
                <div class="alert alert-danger box-size">{{ $errors->first('end_date') }}</div>
            @endif
        </div><!--col-lg-10-->
    </div><!--form control-->
    <div class="form-group">
        {{ Form::label('amount', trans('validation.attributes.backend.promocodes.amount'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
            {{ Form::text('amount', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.promocodes.amount')]) }}
            @if($errors->has('amount'))
                <div class="alert alert-danger box-size">{{ $errors->first('amount') }}</div>
            @endif
        </div><!--col-lg-10-->
    </div><!--form control-->

</div><!--box-body-->

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
