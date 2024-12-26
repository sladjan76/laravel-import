<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'import_type',
        'file_name',
        'original_file_name',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function errors()
    {
        return $this->hasMany(ImportError::class);
    }

    public function audits()
    {
        return $this->hasMany(Audit::class);
    }

    public function scopeSuccessful($query)
    {
        return $query->where('status', 'successful');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }
}
