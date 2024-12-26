@component('mail::message')
    # Import Completed

    Your data import has been completed successfully.

    **Import Details:**
    - Type: {{ $import->import_type }}
    - File: {{ json_decode($import->file_name, true)[array_key_first(json_decode($import->file_name, true))]['original_name'] }}
    - Date: {{ $import->created_at }}

    **Results:**
    - Processed Rows: {{ $result['processed_rows'] }}
    - Errors: {{ $result['error_rows'] }}


    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
