<div class="box-body">

    <div class="form-group">
        {{ Form::label('title', trans('validation.attributes.backend.loudhailers.title'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
            {{ Form::text('title', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.loudhailers.title'), 'required' => 'required']) }}
        </div><!--col-lg-10-->
    </div><!--form control-->

    <div class="form-group">
        {{ Form::label('send_to', trans('validation.attributes.backend.loudhailers.send_to'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
            {{ Form::select('send_to', $partnerTypes, null, ['class' => 'form-control tags box-size', 'required' => 'required']) }}
        </div><!--col-lg-3-->
    </div><!--form control-->

    <div class="form-group">
        {{ Form::label('message', trans('validation.attributes.backend.loudhailers.message'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10 mce-box">
            {{ Form::textarea('message', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.loudhailers.message')]) }}
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
