@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.imports.title')</h3>
    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($imports) > 0 ? 'datatable' : '' }} dt-select">
                <thead>
                <tr>
                    <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>

                    <th>@lang('global.imports.fields.id')</th>
                    <th>@lang('global.imports.fields.import_type')</th>
                    <th>@lang('global.imports.fields.file')</th>
                    <th>@lang('global.imports.fields.status')</th>
                    <th>@lang('global.imports.fields.created')</th>
                    <th>Action</th>

                </tr>
                </thead>

            </table>
        </div>
    </div>
@stop

@section('javascript')
    <script>
        window.route_mass_crud_entries_destroy = '{{ route('admin.import_history.mass_destroy') }}';
        window.onload = function() {
            $(".icheckbox_square-yellow").hide();
        };

    </script>
@endsection

