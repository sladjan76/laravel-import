@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.users.title')</h3>
    <p>
        <a href="{{ route('admin.users.create') }}" class="btn btn-success">@lang('global.app_add_new')</a>
    </p>
    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($users) > 0 ? 'datatable' : '' }} dt-select">
                <thead>
                    <tr>
                        <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>

                        <th>@lang('global.users.fields.id')</th>
                        <th>@lang('global.users.fields.name')</th>
                        <th>@lang('global.users.fields.email')</th>
                        <th>@lang('global.users.fields.created_at')</th>
                        <th>Action</th>

                    </tr>
                </thead>

            </table>
        </div>
    </div>
@stop

@can('view')
    @section('javascript')
        <script>
            window.onload = function() {
                $(".actions").hide();
                $(".icheckbox_square-yellow").hide();
            };
        </script>
    @endsection
@else
    @section('javascript')
        <script>
            window.route_mass_crud_entries_destroy = '{{ route('admin.users.mass_destroy') }}';
            window.onload = function() {
                $(".icheckbox_square-yellow").hide();
            };

        </script>
    @endsection
@endcan
