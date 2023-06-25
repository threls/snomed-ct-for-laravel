<?php

namespace Threls\SnomedCTForLaravel\Commands;
ini_set('memory_limit', -1);

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\ProgressBar;
use Threls\SnomedCTForLaravel\Enums\DescriptionType;

class SnomedIndexCommand extends Command
{
    protected $signature = 'snomed:index {--chunk=5000}';

    protected $description = 'Build the snomed indices table';

    protected string $connection;

    public function handle()
    {
        $this->connection = Config::get('snomed-ct-for-laravel.db.temp.connection');

        DB::connection($this->connection)->disableQueryLog();

        $lastUpdate = $this->getLastUpdate();
        $this->info("Last Update: {$lastUpdate?->toDateString()}");

        $this->info('Indexing Snap Definitions');
        $this->indexTable(tableName: 'snomed_description', since: $lastUpdate);

        $this->info('Indexing Text Definitions');
        $this->indexTable(tableName: 'snomed_text_definition', since: $lastUpdate);

        $this->info('Linking FSN');
        $this->linkFsn();
    }

    protected function getLastUpdate(): ?Carbon
    {
        $first = DB::connection($this->connection)->table('snomed_indices')->orderBy('effective_time', 'desc')->first();

        if ($first) {
            return Carbon::parse($first->effective_time);
        } else {
            return null;
        }
    }

    protected function getChunk(): int
    {
        return (int)$this->option('chunk');
    }


    protected function indexTable(string $tableName, ?Carbon $since): void
    {
        $builder = DB::connection($this->connection)
            ->table($tableName)
            ->leftJoin('snomed_snap_concept', "{$tableName}.conceptId", '=', 'snomed_snap_concept.id')
            ->leftJoin('snomed_refset_language', 'snomed_refset_language.referencedComponentId', '=', "{$tableName}.id")
            ->orderBy("{$tableName}.effectiveTime")
            ->select([
                "{$tableName}.*",
                'snomed_refset_language.refsetId',
                'snomed_refset_language.acceptabilityId',
                'snomed_refset_language.active as snomed_refset_language_active',
                'snomed_snap_concept.active as snomed_snap_concept_active'
            ]);

        if (!is_null($since)) {
            $builder->where("{$tableName}.effectiveTime", '>', $since->endOfDay());
        }

        $bar = $this->output->createProgressBar($builder->count());

        $builder->chunk($this->getChunk(), fn($rows) => $this->index($rows, $bar));

        $bar->finish();

        $this->output->newLine(2);
    }

    public function index(Collection $chunk, ProgressBar &$progressBar): void
    {
        $records = collect([]);

        $chunk->each(function ($row) use ($records) {
            $semanticTag = null;
            if ($row->typeId == DescriptionType::FULLY_SPECIFIED_NAME->value) {
                preg_match('/\([a-zA-Z\/\s]*\)$/', $row->term, $match);
                if (count($match) != 0) {
                    $semanticTag = substr($match[0], 1, -1);
                    $row->term = preg_replace('/ ' . preg_quote($match[0], '/') . '$/', '', $row->term);
                }
            }

            $records->push([
                'id'                     => $row->id,
                'effective_time'         => Carbon::parse($row->effectiveTime)->startOfDay(),
                'concept_id'             => $row->conceptId,
                'type_id'                => $row->typeId,
                'term'                   => $row->term,
                'refset_id'              => $row->refsetId,
                'semantic_tag'           => $semanticTag,
                'acceptability_id'       => $row->acceptabilityId,
                'active'                 => $row->active,
                'concept_active'         => $row->snomed_snap_concept_active ?? false,
                'refset_language_active' => $row->snomed_refset_language_active ?? false,
            ]);
        });

        DB::connection($this->connection)->table('snomed_indices')->upsert($records->toArray(), ['id'], [
            'effective_time',
            'concept_id',
            'type_id',
            'term',
            'refset_id',
            'semantic_tag',
            'acceptability_id'
        ]);

        $progressBar->advance($chunk->count());
    }

    public function linkFsn()
    {
        $sql = <<<SQL
update snomed_indices
set fsn_id           = (select s2.id
                        from snomed_indices s1
                                 inner join snomed_indices s2 on s1.concept_id = s2.concept_id
                            and s2.type_id = 900000000000003001),
    fsn_semantic_tag = (select s2.semantic_tag
                        from snomed_indices s1
                                 inner join snomed_indices s2 on s1.concept_id = s2.concept_id
                            and s2.type_id = 900000000000003001);
SQL;

        DB::connection($this->connection)->statement($sql);
    }
}
