@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.access.users.management') . ' | ' . trans('labels.backend.access.users.edit'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.access.users.edit-profile') }}
    </h1>
@endsection

@section('content')
	{{ Form::model($logged_in_user, ['route' => 'admin.profile.update', 'class' => 'form-horizontal', 'method' => 'PATCH']) }}

     <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.backend.access.users.edit-profile') }}</h3>
        </div>
        <div class="box-body">
            <div class="form-group">
                {{ Form::label('first_name', 'FirstName', ['class' => 'col-lg-4 control-label']) }}
                <div class="col-lg-6">
                    {{ Form::input('text', 'first_name', null, ['Readonly', 'class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.register-user.firstName')]) }}
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('id', 'Id', ['class' => 'col-md-4 control-label']) }}
                <div class="col-md-6">
                    {{ Form::input('text', 'id', null, ['Readonly', 'class' => 'form-control']) }}
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('contact_no', 'Contact No', ['class' => 'col-md-4 control-label']) }}
                <div class="col-md-6">
                    {{ Form::input('text', 'contact_no', null, ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('email', 'Email', ['class' => 'col-md-4 control-label']) }}
                <div class="col-md-6">
                    {{ Form::input('email', 'email', null, ['Readonly', 'class' => 'form-control']) }}
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                </div>
                <div class="col-md-6">
                <h4>Emergency Detail</h4>
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('emergency_name', 'Name', ['class' => 'col-md-4 control-label']) }}
                <div class="col-md-6">
                    {{ Form::input('text', 'emergency_name', null, ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('emergency_relationship', 'Relationship', ['class' => 'col-md-4 control-label']) }}
                <div class="col-md-6">
                    {{ Form::input('text', 'emergency_relationship', null, ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('contactno', 'contact no', ['class' => 'col-md-4 control-label']) }}
                <div class="col-md-6">
                    {{ Form::input('text', 'emergency_contact', null, ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                </div>
                <div class="col-md-6">
                <h4>Activity List</h4>
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('date', 'Name', ['class' => 'col-md-4 control-label']) }}
                <div class="col-md-6">
                    {{ Form::input('text', 'created_at', null, ['Readonly', 'class' => 'form-control']) }}
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('status', 'Status', ['class' => 'col-md-4 control-label']) }}
                <div class="col-md-6">
                {!! Form::select('status',$status, null,['disabled', 'class' => 'form-control','id' => 'customer-option', 'placeholder' => 'Select Customer']) !!}
                </div>
            </div>
            
            <div class="form-group">
                <div class="col-lg-10 col-md-offset-4">
                    {{ Form::submit(trans('labels.general.buttons.update'), ['class' => 'btn btn-primary', 'id' => 'update-profile']) }}
                </div>
            </div>
        </div>
    </div>
{{ Form::close() }}
@endsection
@section('after-scripts')

<script type="text/javascript">
    $(document).ready(function() {
        Backend.Profile.init();
    });
</script>
@endsection
