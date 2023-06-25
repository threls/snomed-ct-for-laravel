<?php

namespace Threls\SnomedCTForLaravel\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Connection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\ProgressBar;
use Threls\SnomedCTForLaravel\Models\SnomedIndex;

class PersistCommand extends Command
{
    protected $signature = 'snomed:persist {--chunk=5000}';

    protected $description = 'Move snomed indices table to MySQL';

    protected Connection $tempDB;

    protected Connection $persistedDB;

    protected string $table = 'snomed_indices';

    public function handle()
    {
        $chunk = $this->option('chunk');

        $tempConnection = Config::get('snomed-ct-for-laravel.db.temp.connection');
        $persistedConnection = Config::get('snomed-ct-for-laravel.db.persisted.connection');

        $this->tempDB = DB::connection($tempConnection);
        $this->persistedDB = DB::connection($persistedConnection);

        $this->tempDB->disableQueryLog();
        $this->persistedDB->disableQueryLog();

        $persistedEffectiveTime = $this->persistedDB->table($this->table)->orderBy('effective_time', 'desc')->first()?->effective_time;

        $this->info("Last Persisted Effective Time: {$persistedEffectiveTime}");

        $query = $this->tempDB->table($this->table);

        if (! is_null($persistedEffectiveTime)) {
            $query->where('effective_time', '>', $persistedEffectiveTime);
        }

        $bar = $this->output->createProgressBar($query->count());

        $query->chunkById($chunk, fn ($rows) => $this->persist($rows, $bar));
        $bar->finish();
    }

    public function persist(Collection $chunk, ProgressBar &$progressBar): void
    {

        $array = $chunk->map(fn ($row) => [
            'id' => $row->id,
            'effective_time' => $row->effective_time,
            'concept_id' => $row->concept_id,
            'type_id' => $row->type_id,
            'term' => $row->term,
            'semantic_tag' => $row->semantic_tag,
            'refset_id' => $row->refset_id,
            'acceptability_id' => $row->acceptability_id,
            'fsn_id' => $row->fsn_id,
            'fsn_semantic_tag' => $row->fsn_semantic_tag,
            'active' => $row->active,
            'concept_active' => $row->concept_active,
            'refset_language_active' => $row->refset_language_active,
        ]);

        /** @var SnomedIndex $snomedIndex */
        $snomedIndex = app(Config::get('snomed-ct-for-laravel.models.index'));
        $snomedIndex->upsert(
            $array->toArray(),
            ['id'],
            [
                'effective_time',
                'concept_id',
                'type_id',
                'term',
                'semantic_tag',
                'refset_id',
                'acceptability_id',
                'fsn_id',
                'fsn_semantic_tag',
                'active',
                'concept_active',
                'refset_language_active',
            ]
        );

        $progressBar->advance($chunk->count());
    }
}
