<?php

namespace Threls\SnomedCTForLaravel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SnapRelationship extends Model
{
    use HasFactory;

    protected $table = 'snomed_snap_relationship';
}
