@extends('layouts.app')

@section('content')

    <div class="row" style="padding-left:15px;padding-right:15px;">
        <div class="panel panel-default col-lg-4">
            <h3 class="page-title">Users</h3>
            <hr>
            <div class="ibox-content">
                <h1 id="stats-galleries-total" class="no-margins">{{ $users }}</h1>
            </div>
        </div>
    </div>

@endsection
