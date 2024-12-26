<?php

namespace App\Services;

use App\Models\ImportError;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Str;


class ImportService
{
    /**
     * The current import that is being processed.
     *
     * @var \App\Models\Import
     */
    protected $import;

    /**
     * The configuration for the current import type.
     *
     * @var array
     */
    protected $config;

    /**
     * The model class for the imported data.
     *
     * @var string
     */
    protected $modelClass;

    /**
     * Counter for processed rows.
     *
     * @var int
     */
    protected $processedRows = 0;

    /**
     * Counter for rows with errors.
     *
     * @var int
     */
    protected $errorRows = 0;

    /**
     * Maximum file size allowed.
     *
     * @var int
     */
    protected $maxFileSize = 52428800;

    /**
     * File format validation rules.
     *
     * @var array
     */
    protected $allowedMimeTypes = [
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'application/vnd.ms-excel',
        'text/csv',
        'text/plain'
    ];

    /**
     * Other file validation rules.
     *
     * @var array
     */
    protected $fileValidationRules = [
        'max_rows' => 10000,
        'required_headers' => true,
        'allow_empty_rows' => false,
        'max_column_length' => 1000
    ];

    public function __construct()
    {
        $this->maxFileSize = config('imports.max_file_size', $this->maxFileSize);
        $this->allowedMimeTypes = config('imports.allowed_mime_types', $this->allowedMimeTypes);
        $this->fileValidationRules = array_merge(
            $this->fileValidationRules,
            config('imports.validation_rules', [])
        );
    }

    /**
     * Process the import.
     *
     * @param  \App\Models\Import $import
     * @return array{processed_rows: int, error_rows: int, file_results: array}
     * @throws \Exception
     */
    public function processImport($import)
    {
        try {
            $this->import = $import;
            $this->config = Config::get("imports.{$import->import_type}");
            $this->modelClass = "App\\Models\\" . Str::studly($import->import_type);

            // Validate model class
            if (!class_exists($this->modelClass)) {
                throw new \Exception("Model class {$this->modelClass} not found");
            }

            // Parse file info
            $files = json_decode($import->file_name, true);
            if (!$files) {
                throw new \Exception("Invalid file information");
            }

            $results = [];
            foreach ($files as $fileKey => $fileInfo) {
                if (!isset($this->config['files'][$fileKey])) {
                    Log::warning("Skipping undefined file configuration for key: {$fileKey}");
                    continue;
                }

                // Process each file
                $results[$fileKey] = $this->processFile(
                    $fileInfo['path'],
                    $this->config['files'][$fileKey]
                );

                // Clean up
                $this->cleanupFile($fileInfo['path']);
            }

            return [
                'processed_rows' => $this->processedRows,
                'error_rows' => $this->errorRows,
                'file_results' => $results
            ];

        } catch (\Exception $e) {
            Log::error('Import processing error: ' . $e->getMessage(), [
                'import_id' => $import->id,
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Validating file.
     *
     * @param  string $filePath
     * @return bool
     * @throws \Exception
     */
    protected function validateFile($filePath)
    {
        if (!Storage::exists($filePath)) {
            throw new \Exception("File not found: {$filePath}");
        }

        $file = Storage::path($filePath);

        // Check file size
        $fileSize = filesize($file);
        if ($fileSize > $this->maxFileSize) {
            throw new \Exception("File size exceeds maximum allowed size of " . ($this->maxFileSize / 1048576) . "MB");
        }

        // Check MIME type
        $mimeType = mime_content_type($file);
        if (!in_array($mimeType, $this->allowedMimeTypes)) {
            throw new \Exception("Invalid file type: {$mimeType}");
        }

        // Check file integrity
        if (!is_readable($file)) {
            throw new \Exception("File is not readable");
        }

        return true;
    }

    /**
     * Validating content of file.
     *
     * @param  array  $worksheet
     * @return bool
     * @throws \Exception
     */
    protected function validateFileContent($worksheet)
    {
        // Check row count
        $rowCount = $worksheet->getHighestRow();
        if ($rowCount > $this->fileValidationRules['max_rows']) {
            throw new \Exception("File contains too many rows (maximum: {$this->fileValidationRules['max_rows']})");
        }

        // Validate cell content length
        $highestColumn = $worksheet->getHighestColumn();
        $maxLength = $this->fileValidationRules['max_column_length'];

        for ($row = 1; $row <= $rowCount; $row++) {
            for ($col = 'A'; $col <= $highestColumn; $col++) {
                $cellValue = $worksheet->getCell($col . $row)->getValue();
                if (strlen($cellValue) > $maxLength) {
                    throw new \Exception("Cell {$col}{$row} exceeds maximum length of {$maxLength} characters");
                }
            }
        }

        return true;
    }

    /**
     * Process a single file from the import.
     *
     * @param  string $filePath
     * @param  array  $fileConfig
     * @return array{processed: int, errors: int}
     * @throws \Exception
     */
    protected function processFile($filePath, $fileConfig)
    {
        try {
            // Validate file
            $this->validateFile($filePath);

            $file = Storage::path($filePath);
            $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

            // Create reader
            $reader = $this->createReader($extension);
            $spreadsheet = $reader->load($file);
            $worksheet = $spreadsheet->getActiveSheet();

            // Validate file content
            $this->validateFileContent($worksheet);

            // Process rows
            return $this->processRows($worksheet, $fileConfig);

        } catch (\Exception $e) {
            Log::error('File processing error', [
                'file' => $filePath,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Create appropriate spreadsheet reader based on file extension.
     *
     * @param  string  $extension
     * @return \PhpOffice\PhpSpreadsheet\Reader\IReader
     * @throws \Exception
     */
    protected function createReader($extension)
    {
        switch ($extension) {
            case 'csv':
                $reader = IOFactory::createReader('Csv');
                $reader->setDelimiter(',');
                $reader->setEnclosure('"');
                $reader->setSheetIndex(0);
                break;
            case 'xlsx':
                $reader = IOFactory::createReader('Xlsx');
                break;
            case 'xls':
                $reader = IOFactory::createReader('Xls');
                break;
            default:
                throw new \Exception("Unsupported file type: {$extension}");
        }

        return $reader;
    }

    /**
     * Validating headers.
     *
     * @param  array  $headers
     * @param  array  $fileConfig
     * @return array
     * @throws \Exception
     */
    protected function validateHeaders($headers, $fileConfig)
    {
        $headers = array_map('trim', array_filter($headers));

        // Check required headers
        $requiredHeaders = array_map(function ($field) {
            return $field['label'];
        }, $fileConfig['headers_to_db']);

        $missingHeaders = array_diff($requiredHeaders, $headers);
        if (!empty($missingHeaders)) {
            throw new \Exception("Missing required headers: " . implode(', ', $missingHeaders));
        }

        // Check for duplicate headers
        $duplicates = array_filter(array_count_values($headers), function($count) {
            return $count > 1;
        });

        if (!empty($duplicates)) {
            throw new \Exception("Duplicate headers found: " . implode(', ', array_keys($duplicates)));
        }

        return $headers;
    }

    /**
     * Processing row.
     *
     * @param  array  $worksheet
     * @param  array  $fileConfig
     * @return array
     */
    protected function processRows($worksheet, $fileConfig)
    {
        $rows = $worksheet->toArray();
        if (empty($rows)) {
            throw new \Exception("File is empty");
        }

        // Validate and process headers
        $headers = $this->validateHeaders(array_shift($rows), $fileConfig);

        $processedCount = 0;
        $errorCount = 0;

        foreach ($rows as $rowIndex => $row) {
            $rowNumber = $rowIndex + 2; // Adding 2 for header row and 1-based index

            // Skip empty rows if not allowed
            if (!$this->fileValidationRules['allow_empty_rows'] && empty(array_filter($row))) {
                continue;
            }

            // Process row with transaction
            try {
                \DB::beginTransaction();

                $mappedData = $this->mapRowToDatabase($row, $headers, $fileConfig['headers_to_db']);

                if ($mappedData === false) {
                    $errorCount++;
                    \DB::rollBack();
                    continue;
                }

                $this->saveRow($mappedData, $fileConfig['update_or_create'] ?? []);
                $processedCount++;

                \DB::commit();
            } catch (\Exception $e) {
                \DB::rollBack();
                $this->logError($rowNumber, 'Database Error', '', $e->getMessage());
                $errorCount++;
            }
        }

        $this->processedRows += $processedCount;
        $this->errorRows += $errorCount;

        return [
            'processed' => $processedCount,
            'errors' => $errorCount
        ];
    }

    /**
     * Map row data to database fields.
     *
     * @param  array  $row
     * @param  array  $headers
     * @param  array  $mapping
     * @return array|false
     */
    protected function mapRowToDatabase($row, $headers, $mapping)
    {
        $data = [];
        $rowArray = array_combine($headers, $row);

        foreach ($mapping as $dbField => $fieldConfig) {
            $value = $rowArray[$fieldConfig['label']] ?? null;

            // Convert value to proper type
            $value = $this->convertValue($value, $fieldConfig['type']);

            $rules = $this->processValidationRules($fieldConfig['validation']);

            // Validate field
            $validator = Validator::make(
                ['field' => $value],
                ['field' => $rules]
            );

            if ($validator->fails()) {
                $this->logError(
                    $this->processedRows + 1,
                    $fieldConfig['label'],
                    $value,
                    $validator->errors()->first('field')
                );
                return false;
            }

            $data[$dbField] = $value;
        }

        return $data;
    }

    /**
     * Convert value to appropriate type.
     *
     * @param  mixed  $value
     * @param  string $type
     * @return mixed
     */
    protected function convertValue($value, $type)
    {
        if ($value === null) {
            return null;
        }

        switch ($type) {
            case 'date':
                return !empty($value) ? date('Y-m-d', strtotime($value)) : null;
            case 'double':
                return !empty($value) ? (float) str_replace(['$', ','], '', $value) : 0;
            case 'integer':
                return !empty($value) ? (int) $value : 0;
            case 'boolean':
                if (is_string($value)) {
                    return in_array(strtolower($value), ['yes', 'true', '1', 'on']);
                }
                return !empty($value);
            default:
                return trim((string) $value);
        }
    }

    /**
     * Save or update a row in the database.
     *
     * @param  array  $data
     * @param  array  $updateKeys
     * @return void
     */
    protected function saveRow($data, $updateKeys = [])
    {
        if (empty($updateKeys)) {
            $model = new $this->modelClass($data);
            $model->save();
            return;
        }

        $query = $this->modelClass::query();
        foreach ($updateKeys as $key) {
            $query->where($key, $data[$key]);
        }

        $model = $query->first();

        if ($model) {
            $model->fill($data);
            if ($model->isDirty()) {
                $model->save();
            }
        } else {
            $model = new $this->modelClass($data);
            $model->save();
        }
    }

    /**
     * Process validation rules to handle array format.
     *
     * @param  array  $validationConfig
     * @return array
     */
    protected function processValidationRules($validationConfig)
    {
        $rules = [];

        foreach ($validationConfig as $key => $value) {
            if (is_numeric($key)) {
                // Simple rule like 'required'
                $rules[] = $value;
            } else {
                // Rule with parameters like 'in' => ['PT', 'Amazon']
                if (is_array($value)) {
                    $rules[] = $key . ':' . implode(',', $value);
                } else {
                    $rules[] = $key . ':' . $value;
                }
            }
        }

        return $rules;
    }

    /**
     * Cleaning up file at the end.
     *
     * @param  string  $filePath
     * @return void
     */
    protected function cleanupFile($filePath)
    {
        try {
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
                Log::info("Cleaned up file: {$filePath}");
            }
        } catch (\Exception $e) {
            Log::warning("Failed to cleanup file: {$filePath}", ['error' => $e->getMessage()]);
        }
    }

    /**
     * Log an import error.
     *
     * @param  int     $rowNumber
     * @param  string  $column
     * @param  string  $value
     * @param  string  $message
     * @return void
     */
    protected function logError($rowNumber, $column, $value, $message)
    {
        ImportError::create([
            'import_id' => $this->import->id,
            'row_number' => $rowNumber,
            'column_name' => $column,
            'column_value' => $value,
            'error_message' => $message
        ]);

        $this->errorRows++;
    }
}
