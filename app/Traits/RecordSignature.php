<?php

namespace App\Traits;

trait RecordSignature
{
    /**
     * This trait boot (aka "bootNameOfTrait")
     *
     * Set updated_by, created_by, deleted_by
     *
     * @return void
     */
    protected static function bootRecordSignature(): void
    {
        static::creating(function ($model) {
            if (auth()->check()) {
                $model->created_by = auth()->user()->getAuthIdentifier();
                $model->updated_by = auth()->user()->getAuthIdentifier();
            }
        });

        static::updating(function ($model) {
            if (auth()->check()) {
                $model->updated_by = auth()->user()->getAuthIdentifier();
            }
        });

        static::deleting(function ($model) {
            if (auth()->check()) {
                $model->deleted_by = auth()->user()->getAuthIdentifier();
            }
        });
    }
}
