<?php

namespace Threls\SnomedCTForLaravel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SnomedDescription extends Model
{
    protected $table = 'snomed_description';

    protected $fillable = [
        'id',
        'effectiveTime',
        'active',
        'moduleId',
        'conceptId',
        'languageCode',
        'typeId',
        'term',
        'caseSignificanceId',
    ];

    protected $casts = [
      'active' => 'boolean'
    ];

    public $timestamps = false;

    public function snomedRefsetLanguage(): HasMany
    {
        return $this->hasMany(SnomedRefsetLanguage::class, 'referencedComponentId', 'id');
    }

    public function snomedSnapConcept(): BelongsTo
    {
        return $this->belongsTo(SnomedSnapConcept::class, 'conceptId', 'id');
    }
}
