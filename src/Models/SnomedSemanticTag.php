<?php

namespace Threls\SnomedCTForLaravel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class SnomedSemanticTag extends Model
{
    protected $fillable = ['label'];

    public $timestamps = false;

    public function snomedIndices()
    {
        return $this->hasMany(Config::get('snomed-ct-for-laravel.models.index'));
    }
}
