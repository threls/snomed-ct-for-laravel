<?php

namespace Threls\SnomedCTForLaravel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SnomedSnapConcept extends Model
{
    use HasFactory;

    protected $table = 'snomed_snap_concept';

    public $timestamps = false;

    public $casts = [
        'active' => 'bool'
    ];

    public function snomedDescriptions(): HasMany
    {
        return $this->hasMany(SnomedDescription::class, 'conceptId', 'id');
    }

    public function snomedTextDefinitions(): HasMany
    {
        return $this->hasMany(SnomedTextDefinition::class, 'conceptId', 'id');
    }
}
