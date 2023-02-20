<?php

namespace Threls\SnomedCTForLaravel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SnapRefsetAttributeValue extends Model
{
    use HasFactory;

    protected $table = 'snomed_snap_refset_attributeValue';
}
