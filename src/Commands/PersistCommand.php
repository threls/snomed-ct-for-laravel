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
    protected $signature = 'snomed:persist {--chunk=5000} {--index}';

    protected $description = 'Move snomed indices table to MySQL';

    protected Connection $tempDB;

    protected Connection $persistedDB;

    protected string $table = 'snomed_indices';

    public function handle()
    {
        $chunk = $this->option('chunk');
        $doIndex = $this->option('index');

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

        $query->chunkById($chunk, fn ($rows) => $this->persist($rows, $bar, $doIndex));
        $bar->finish();
    }

    public function persist(Collection $chunk, ProgressBar &$progressBar, bool $doIndex): void
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

        if ($doIndex) {
            $this->saveAndIndex($array, $progressBar);
        } else {
            $this->upsert($array, $progressBar);
        }
    }

    protected function saveAndIndex(Collection $chunk, ProgressBar &$progressBar)
    {
        $chunk->each(function (array $record) use (&$progressBar) {
            /** @var SnomedIndex $snomedIndex */
            $snomedIndex = app(Config::get('snomed-ct-for-laravel.models.index'));

            $snomedIndex->updateOrCreate(
                ['id' => $record['id']],
                [
                    'effective_time' => $record['effective_time'],
                    'concept_id' => $record['concept_id'],
                    'type_id' => $record['type_id'],
                    'term' => $record['term'],
                    'semantic_tag' => $record['semantic_tag'],
                    'refset_id' => $record['refset_id'],
                    'acceptability_id' => $record['acceptability_id'],
                    'fsn_id' => $record['fsn_id'],
                    'fsn_semantic_tag' => $record['fsn_semantic_tag'],
                    'active' => $record['active'],
                    'concept_active' => $record['concept_active'],
                    'refset_language_active' => $record['refset_language_active'],
                ]
            );

            $progressBar->advance();
        });
    }

    protected function upsert(Collection $chunk, ProgressBar &$progressBar)
    {
        /** @var SnomedIndex $snomedIndex */
        $snomedIndex = app(Config::get('snomed-ct-for-laravel.models.index'));
        $snomedIndex->upsert(
            $chunk->toArray(),
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
