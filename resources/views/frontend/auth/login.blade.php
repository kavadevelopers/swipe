@extends('frontend.layouts.app')

@section('content')

    

        <div class="Login_form">
            
            <div class="centerv panel panel-default">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if( Session::has( 'success' ))
                    <div class="alert alert-success">
                        {{ Session::get( 'success' ) }}
                    </div>
                @elseif( Session::has( 'warning' ))
                     <div class="alert alert-warning">
                        {{ Session::get( 'warning' ) }}
                    </div>
                @endif
                <div class="panel-heading text-center text-bold">{{ trans('SIGN IN')}}</div>

                <div class="panel-body">

                    {{ Form::open(['route' => 'frontend.auth.login', 'class' => 'form-horizontal']) }}

                    <div class="form-group">
                        {{ Form::label('user name', trans('validation.attributes.frontend.register-user.email'), ['class' => 'control-label']) }}
                            {{ Form::input('text', 'email', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.register-user.email')]) }}
                    </div><!--form-group-->

                    <div class="form-group">
                        {{ Form::label('password', trans('validation.attributes.frontend.register-user.password'), ['class' => 'control-label']) }}
                            {{ Form::input('password', 'password', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.register-user.password')]) }}

                    </div><!--form-group-->

<!--                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <div class="checkbox">
                                <label>
                                    {{ Form::checkbox('remember') }} {{ trans('labels.frontend.auth.remember_me') }}
                                </label>
                            </div>
                        </div>col-md-6
                    </div>form-group-->

                    <div class="form-group">
                        {{ Form::submit(trans('Login'), ['class' => 'btn btn-primary btn-block']) }}
                        
                        
                    </div>
            <div class="form-group">
                <i class="fa fa-lock"></i>
                            {{ link_to_route('frontend.auth.password.reset', trans('Forgot Password')) }}
                        </div><!--form-group-->

                    {{ Form::close() }}

                    <div class="row text-center">

                    </div>
                </div><!-- panel body -->

            </div><!-- panel -->

        </div><!-- Login_form -->

    

@endsection