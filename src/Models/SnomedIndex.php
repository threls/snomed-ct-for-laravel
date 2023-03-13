<?php

namespace Threls\SnomedCTForLaravel\Models;

use Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Threls\SnomedCTForLaravel\Enums\DescriptionType;

class SnomedIndex extends Model
{
    public $timestamps = false;

    protected $dates = ['effective_time'];

    protected $table = 'snomed_indices';

    protected $casts = [
        'type_id' => DescriptionType::class
    ];

    public function fullySpecifiedName(): BelongsTo
    {
        return $this->belongsTo(Config::get('snomed-ct-for-laravel.models.index'), 'fsn_id', 'id');
    }

    public function computedFullySpecifiedName(): BelongsTo
    {
        return $this->belongsTo(Config::get('snomed-ct-for-laravel.models.index'), 'concept_id', 'concept_id')
            ->where('type_id', DescriptionType::FULLY_SPECIFIED_NAME);
    }
}
