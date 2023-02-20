<?php

namespace Threls\SnomedCTForLaravel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SnapConcept extends Model
{
    use HasFactory;

    protected $table = 'snomed_snap_concept';
}
