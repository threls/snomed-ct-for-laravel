<?php

namespace Threls\SnomedCTForLaravel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SnomedTextDefinition extends Model
{
    protected $table = 'snomed_textDefinition';

    public $timestamps = false;

    public function snomedRefsetLanguage(): HasMany
    {
        return $this->hasMany(SnomedRefsetLanguage::class, 'referencedComponentId', 'id');
    }

    protected function snomedSnapConcept(): BelongsTo
    {
        return $this->belongsTo(SnomedSnapConcept::class, 'conceptId', 'id');
    }
}
