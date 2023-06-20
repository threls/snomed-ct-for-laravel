<?php

namespace Threls\SnomedCTForLaravel\Actions;

use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class SnomedMetaActions
{


    protected function getBuilder(): Builder
    {
        return DB::connection(config('snomed-ct-for-laravel.db.temp.connection'))->table('snomed_meta');
    }

    public function setReleaseEffectiveTime(Carbon $effectiveTime)
    {
        $this->getBuilder()->upsert(
            [
                'key'        => 'effectiveTime',
                'value'      => $effectiveTime->toDateString(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            ['key'],
            ['value', 'updated_at']
        );
    }


    public function getReleaseEffectiveTime(): Carbon|null
    {
        $effectiveTime = $this->getBuilder()->where('key', 'effectiveTime')->first();

        if (!is_null($effectiveTime?->value)) {
            return Carbon::parse($effectiveTime->value)->startOfDay();
        } else {
            return null;
        }
    }


}
