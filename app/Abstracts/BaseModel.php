<?php

namespace App\Abstracts;

use App\Traits\RecordSignature;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Base Eloquent Model
 */
abstract class BaseModel extends Model
{
    use HasFactory, RecordSignature;

    public $timestamps = true;

    protected $hidden = [
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
    ];

    /**
     * The attributes that aren't mass assignable.
     * (reverse of $fillable)
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Check ownership of a Model
     *
     * @return bool
     */
    public function checkOwnership(): bool
    {
        return true;
    }

    /**
     * Boot
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (method_exists($model, 'checkConstraints') && ! $model->checkConstraints()) {
                return false;
            }
        });
    }
}
