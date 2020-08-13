<div class="box-body">
    <div class="form-group">
        <!-- Create Your Field Label Here -->
        <!-- Look Below Example for reference -->

        <div class="form-group">
            {{ Form::label('title', trans('validation.attributes.backend.policies.title'), ['class' => 'col-lg-2 control-label required']) }}

            <div class="col-lg-10">
                {{ Form::text('title', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.policies.title'), 'required' => 'required']) }}
            </div><!--col-lg-10-->
        </div><!--form control-->

        <div class="form-group">
            {{ Form::label('content', trans('validation.attributes.backend.policies.content'), ['class' => 'col-lg-2 control-label required']) }}

            <div class="col-lg-10 mce-box">
                {{ Form::textarea('content', null, ['class' => 'form-control box-size', 'required' => 'required']) }}
            </div><!--col-lg-10-->
        </div><!--form control-->
    </div><!--form-group-->
</div><!--box-body-->

@section("after-scripts")
    <script type="text/javascript">
        //Put your javascript needs in here.
        //Don't forget to put `@`parent exactly after `@`section("after-scripts"),
        //if your create or edit blade contains javascript of its own
        $( document ).ready( function() {
            //Everything in here would execute after the DOM is ready to manipulated.
            Backend.Policies.init('{{ config('locale.languages.' . app()->getLocale())[1] }}');
        });
    </script>
@endsection
