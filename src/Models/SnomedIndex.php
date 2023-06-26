<?php

namespace Threls\SnomedCTForLaravel\Models;

use Illuminate\Database\Eloquent\Model;
use Threls\SnomedCTForLaravel\Enums\DescriptionType;

class SnomedIndex extends Model
{
    public $timestamps = false;

    protected $dates = ['effective_time'];

    protected $table = 'snomed_indices';

    protected $casts = [
        'type_id' => DescriptionType::class,
    ];
}
