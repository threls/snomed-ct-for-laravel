<?php

namespace Threls\SnomedCTForLaravel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Threls\SnomedCTForLaravel\Enums\SemanticTag;

/**
 * @property string $label
 */
class SnomedSemanticTag extends Model
{
    protected $fillable = ['label'];

    public $timestamps = false;


    protected $casts = ['semantic_tag' => SemanticTag::class];
}
