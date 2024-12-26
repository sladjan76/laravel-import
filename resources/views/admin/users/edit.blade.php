@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.users.title')</h3>
    {!! Form::model($user, ['method' => 'PUT', 'enctype' => 'multipart/form-data', 'route' => ['admin.users.update', $user->id]]) !!}
    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_edit')
        </div>
        <div class="panel-body">
            @can('users_manage')
                <div class="row">
                    <div class="col-xs-12 form-group">
                        {!! Form::label('name', 'Name*', ['class' => 'control-label']) !!}
                        {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '', 'value' => $user->name]) !!}
                        <p class="help-block"></p>
                        @if($errors->has('name'))
                            <p class="help-block">
                                {{ $errors->first('name') }}
                            </p>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 form-group">
                        {!! Form::label('roles', 'Roles*', ['class' => 'control-label']) !!}
                        {!! Form::select('roles[]', $roles, old('roles') ? old('role') : $user->roles()->pluck('name', 'name'), ['class' => 'form-control select2', 'multiple' => 'multiple', 'required' => '']) !!}
                        <p class="help-block"></p>
                        @if($errors->has('roles'))
                            <p class="help-block">
                                {{ $errors->first('roles') }}
                            </p>
                        @endif
                    </div>
                </div>
            @endcan
        </div>
    </div>
    {!! Form::submit(trans('global.app_update'), ['class' => 'btn btn-danger']) !!}
    <input class="btn btn-danger" type="button" onclick="javascript: goBack();" value="Cancel">
    {!! Form::close() !!}
@stop

