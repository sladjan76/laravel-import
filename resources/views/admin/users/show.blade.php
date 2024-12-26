@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.users.title')</h3>


    <div class="panel panel-default">
        <div class="panel-heading">
            Info
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-6 form-group">
                    {!! Form::label('name', 'Name:', ['class' => 'control-label']) !!}
                    {!! $user->name !!}
                </div>
                <div class="col-xs-6 form-group">
                    {!! Form::label('email', 'Email:', ['class' => 'control-label']) !!}
                    {!! $user->email !!}

                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('register_date', 'Register Date:', ['class' => 'control-label']) !!}
                    {!! $user->created_at !!}
                </div>
            </div>
        </div>
    </div>

@stop

