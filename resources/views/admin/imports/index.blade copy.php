@extends('layouts.app')


@section('content')
    <h3 class="page-title">Data Import</h3>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Import Data</h3>
        </div>
        <div class="box-body">
            <form action="{{ route('admin.imports.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="import_type">Import Type</label>
                    <select name="import_type" id="import_type" class="form-control" required>
                        <option value="">Select Import Type</option>
                        @foreach($importTypes as $type => $config)
                            <option value="{{ $type }}">{{ $config['label'] }}</option>
                        @endforeach
                    </select>
                    @error('import_type')
                    <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>

                @if(session('import_error'))
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-ban"></i> Import Error!</h4>
                        <p>{{ session('import_error') }}</p>
                        @if(session('error_details'))
                            <hr>
                            <strong>Error Details:</strong>
                            <ul>
                                @foreach(session('error_details') as $detail)
                                    <li>{{ $detail }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endif


                <div id="file-inputs"></div>

                @if(session('validation_errors'))
                    <div class="alert alert-warning">
                        <h4><i class="icon fa fa-warning"></i> Validation Errors:</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Row</th>
                                    <th>Column</th>
                                    <th>Value</th>
                                    <th>Error</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach(session('validation_errors') as $error)
                                    <tr>
                                        <td>{{ $error['row'] }}</td>
                                        <td>{{ $error['column'] }}</td>
                                        <td><code>{{ $error['value'] }}</code></td>
                                        <td>{{ $error['message'] }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

                <div id="required-headers" class="well" style="display: none;">
                    <h4>Required Headers:</h4>
                    <div id="headers-list"></div>
                </div>

                <button type="submit" class="btn btn-primary">Import</button>
            </form>
        </div>
    </div>

@stop
@section('javascript')
    <script>
        const importConfigs = @json($importTypes);

        $('#import_type').change(function() {
            const type = $(this).val();
            const config = importConfigs[type];

            if (!config) {
                $('#file-inputs').empty();
                $('#required-headers').hide();
                return;
            }

            // Generate file inputs
            let fileInputsHtml = '';
            Object.entries(config.files).forEach(([key, fileConfig]) => {
                fileInputsHtml += `
        <div class="form-group">
            <label>${fileConfig.label}</label>
            <input type="file" name="files[${key}]" class="form-control" accept=".csv,.xlsx">
        </div>
    `;
            });
            $('#file-inputs').html(fileInputsHtml);

            // Show required headers
            let headersHtml = '';
            Object.values(config.files).forEach(fileConfig => {
                Object.entries(fileConfig.headers_to_db).forEach(([key, field]) => {
                    headersHtml += `<div>${field.label} (${field.type})</div>`;
                });
            });
            $('#headers-list').html(headersHtml);
            $('#required-headers').show();
        });
    </script>
@endsection
