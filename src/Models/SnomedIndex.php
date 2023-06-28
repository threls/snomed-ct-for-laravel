<?php

namespace Threls\SnomedCTForLaravel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Config;
use Threls\SnomedCTForLaravel\Enums\DescriptionType;

class SnomedIndex extends Model
{
    public $timestamps = false;

    protected $dates = ['effective_time'];

    protected $table = 'snomed_indices';

    protected $fillable = [
        'id',
        'effective_time',
        'concept_id',
        'type_id',
        'term',
        'semantic_tag',
        'refset_id',
        'acceptability_id',
        'fsn_id',
        'fsn_semantic_tag',
        'active',
        'concept_active',
        'refset_language_active',
    ];

    protected $casts = [
        'type_id' => DescriptionType::class,
    ];

    public function fullySpecifiedName(): BelongsTo
    {
        return $this->belongsTo(Config::get('snomed-ct-for-laravel.models.index'), 'fsn_id', 'id');
    }

}
