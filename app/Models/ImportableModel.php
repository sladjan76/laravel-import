<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class ImportableModel extends Model
{
    use HasFactory;

    public function audits(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Audit::class, 'auditable');
    }

    protected static function boot()
    {
        parent::boot();

        static::updating(function ($model) {
            $changes = $model->getDirty();
            foreach ($changes as $column => $newValue) {
                $oldValue = $model->getOriginal($column);

                if ($oldValue !== $newValue) {
                    Audit::create([
                        'import_id' => request()->import_id ?? null,
                        'model_type' => get_class($model),
                        'model_id' => $model->id,
                        'column' => $column,
                        'old_value' => $oldValue,
                        'new_value' => $newValue
                    ]);
                }
            }
        });
    }
}
