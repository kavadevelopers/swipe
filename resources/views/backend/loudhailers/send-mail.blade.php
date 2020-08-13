@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.loudhailers.management') . ' | ' . trans('labels.backend.loudhailers.send-mail'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.loudhailers.management') }}
    </h1>
@endsection

@section('content')
    {{ Form::open(['route' => 'admin.loudhailers.sendmail', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'loudhailer-send-mail']) }}

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('labels.backend.loudhailers.send-mail') }}</h3>

                <div class="box-tools pull-right">

                </div><!--box-tools pull-right-->
            </div><!--box-header with-border-->

            <div class="box-body">
                <div class="form-group">

                    <div class="box-body">

                        <div class="form-group">
                            {{ Form::label('send_to', trans('validation.attributes.backend.loudhailers.send_to'), ['class' => 'col-lg-2 control-label required']) }}

                            <div class="col-lg-10">
                                {{ Form::select('send_to', $partnerTypes, null, ['class' => 'form-control tags box-size', 'required' => 'required']) }}
                            </div><!--col-lg-3-->
                        </div><!--form control-->

                        <div class="form-group">
                            {{ Form::label('subject', trans('validation.attributes.backend.loudhailers.subject'), ['class' => 'col-lg-2 control-label required']) }}

                            <div class="col-lg-10">
                                {{ Form::text('subject', null, ['class' => 'form-control box-size', 'maxlength' => 190, 'placeholder' => trans('validation.attributes.backend.loudhailers.subject'), 'required' => 'required']) }}
                            </div><!--col-lg-10-->
                        </div><!--form control-->

                        <div class="form-group">
                            {{ Form::label('message', trans('validation.attributes.backend.loudhailers.message'), ['class' => 'col-lg-2 control-label required']) }}

                            <div class="col-lg-10 mce-box">
                                {{ Form::textarea('message', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.loudhailers.message')]) }}
                            </div><!--col-lg-10-->
                        </div><!--form control-->

                    </div>
                    <div class="edit-form-btn">
                        {{ Form::submit("Send", ['class' => 'btn btn-primary btn-md']) }}
                        <div class="clearfix"></div>
                    </div><!--edit-form-btn-->
                </div><!-- form-group -->
            </div><!--box-body-->
        </div><!--box box-success-->
    {{ Form::close() }}
@endsection
