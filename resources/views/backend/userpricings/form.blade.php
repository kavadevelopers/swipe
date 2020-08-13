<div class="box-body">
<div class="form-group">
        {{ Form::label('vehical_name', trans('Vehical Name'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
            {{ Form::text('vehical_name', null, ['readonly', 'class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.faqs.question'), 'required' => 'required']) }}
        </div><!--col-lg-10-->
    </div><!--form control-->

    <div class="form-group">
        {{ Form::label('user_price', trans('Price'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
            {{ Form::text('user_price', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.faqs.question'), 'required' => 'required']) }}
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
