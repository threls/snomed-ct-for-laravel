<?php

namespace Threls\SnomedCTForLaravel\Jobs;

use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportSnomedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $table,
        public array  $records,
        public array  $upsertUniqueBy,
        public array  $upsertUpdate,
        public string $tableConnection
    )
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::connection($this->tableConnection)->table($this->table)->upsert($this->records, $this->upsertUniqueBy, $this->upsertUpdate);
    }
}
