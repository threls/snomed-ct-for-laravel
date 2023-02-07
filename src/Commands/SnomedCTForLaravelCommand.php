<?php

namespace Threls\SnomedCTForLaravel\Commands;

use Illuminate\Console\Command;

class SnomedCTForLaravelCommand extends Command
{
    public $signature = 'snomed-ct-for-laravel';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
