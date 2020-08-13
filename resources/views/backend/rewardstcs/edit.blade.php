@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.rewardstcs.management') . ' | ' . trans('labels.backend.rewardstcs.edit'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.rewardstcs.management') }}
        <small>{{ trans('labels.backend.rewardstcs.edit') }}</small>
    </h1>
@endsection

@section('content')
    {{ Form::model($rewardstcs, ['route' => ['admin.rewardstcs.update', $rewardstcs], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH', 'id' => 'edit-rewardstc']) }}

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('labels.backend.rewardstcs.edit') }}</h3>

                <div class="box-tools pull-right">
                    @include('backend.rewardstcs.partials.rewardstcs-header-buttons')
                </div><!--box-tools pull-right-->
            </div><!--box-header with-border-->

            <div class="box-body">
                <div class="form-group">
                    {{-- Including Form blade file --}}
                    @include("backend.rewardstcs.form")
                    <div class="edit-form-btn">
                        {{ link_to_route('admin.rewardstcs.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                        {{ Form::submit(trans('buttons.general.crud.update'), ['class' => 'btn btn-primary btn-md']) }}
                        <div class="clearfix"></div>
                    </div><!--edit-form-btn-->
                </div><!--form-group-->
            </div><!--box-body-->
        </div><!--box box-success -->
    {{ Form::close() }}
@endsection
