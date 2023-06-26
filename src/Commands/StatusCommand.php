<?php

namespace Threls\SnomedCTForLaravel\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class StatusCommand extends Command
{
    protected $signature = 'snomed:status';

    protected $description = 'Get snomed status';

    public function handle()
    {
        $this->info('Versions: ');

        $this->table(['Connection', 'Latest Effective Time'], [
            ['SQLite', $this->getLastUpdate('sqlite')],
            ['MySQL', $this->getLastUpdate('mysql')],
        ]);
    }

    protected function getLastUpdate(string $connection): ?string
    {
        $date = DB::connection($connection)->table('snomed_indices')->orderBy('effective_time', 'desc')->first();

        return is_null($date) ? null : Carbon::parse($date->effective_time)->toDateString();
    }
}
