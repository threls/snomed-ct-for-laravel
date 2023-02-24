<?php

namespace Threls\SnomedCTForLaravel\Models;

use Illuminate\Database\Eloquent\Model;

class SnomedIndex extends Model
{

    public $timestamps = false;

    protected $dates = ['effective_time'];

}
