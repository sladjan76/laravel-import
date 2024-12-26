@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.import_errors.title') on File: {{ $import->original_file_name }}</h3>
    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($import_errors) > 0 ? 'datatable' : '' }} dt-select">
                <thead>
                <tr>
                    <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>

                    <th>@lang('global.import_errors.fields.id')</th>
                    <th>@lang('global.import_errors.fields.import_id')</th>
                    <th>@lang('global.import_errors.fields.row_number')</th>
                    <th>@lang('global.import_errors.fields.column_name')</th>
                    <th>@lang('global.import_errors.fields.column_value')</th>
                    <th>@lang('global.import_errors.fields.error_message')</th>

                    <th>Action</th>

                </tr>
                </thead>

                <tbody>
                @if (count($import_errors) > 0)
                    @foreach ($import_errors as $import_error)
                        <tr data-entry-id="{{ $import_error->id }}">
                            <td></td>
                            <td>{{ $import_error->id }}</td>
                            <td>{{ $import_error->import_id }}</td>
                            <td>{{ $import_error->row_number }}</td>
                            <td>{{ $import_error->column_name }}</td>
                            <td>{{ $import_error->column_value }}</td>
                            <td>{{ $import_error->error_message }}</td>
                            <td></td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="8">@lang('global.app_no_entries_in_table')</td>
                    </tr>
                @endif
                </tbody>

            </table>
        </div>
    </div>
@stop

@section('javascript')
    <script>
        window.onload = function() {
            $(".actions").hide();
            $(".icheckbox_square-yellow").hide();
        };
    </script>
@endsection

