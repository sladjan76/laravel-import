@component('mail::message')
    # Import Failed

    Your data import has encountered an error and could not be completed.

    **Import Details:**
    - Type: {{ $import->import_type }}
    - File: {{ json_decode($import->file_name, true)[array_key_first(json_decode($import->file_name, true))]['original_name'] }}
    - Date: {{ $import->created_at }}

    **Error Message:**
    {{ $error }}
@endcomponent
