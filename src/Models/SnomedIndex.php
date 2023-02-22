<?php

namespace Threls\SnomedCTForLaravel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Config;

class SnomedIndex extends Model
{
    protected $table = 'snomed_index';

    public $timestamps = false;

    protected $dates = ['effective_time'];

}
