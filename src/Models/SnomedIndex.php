<?php

namespace Threls\SnomedCTForLaravel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Config;

class SnomedIndex extends Model
{
    protected $table = 'snomed_index';

    public $timestamps = false;


    public function semanticTag(): BelongsTo
    {
        return $this->belongsTo(Config::get('snomed-ct-for-laravel.models.semantic_tag'),'snomed_semantic_tag_id');
    }
}
