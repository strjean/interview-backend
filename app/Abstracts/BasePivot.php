<?php

namespace App\Abstracts;

use App\Traits\RecordSignature;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Base Eloquent Pivot
 */
abstract class BasePivot extends Pivot
{
    use RecordSignature;
}
