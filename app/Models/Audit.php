<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    use HasFactory;

    protected $fillable = [
        'import_id',
        'model_type',
        'model_id',
        'column',
        'old_value',
        'new_value'
    ];

    public function import()
    {
        return $this->belongsTo(Import::class);
    }

    public function auditable()
    {
        return $this->morphTo();
    }
}
