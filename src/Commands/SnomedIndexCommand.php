<?php

namespace Threls\SnomedCTForLaravel\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Threls\SnomedCTForLaravel\Jobs\ImportSnomedJob;
use Threls\SnomedCTForLaravel\Models\SnomedDescription;
use Threls\SnomedCTForLaravel\Models\SnomedIndex;
use Threls\SnomedCTForLaravel\Models\SnomedRefsetLanguage;
use Threls\SnomedCTForLaravel\Models\SnomedTextDefinition;

class SnomedIndexCommand extends Command
{
    protected $signature = 'snomed:index';

    protected $description = 'Build the snomed indices table';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        DB::connection()->disableQueryLog();

        $this->info('Indexing Snap Definitions');
        $this->indexSnapDefinitions();

        $this->info('Indexing Text Definitions');
        $this->indexTextDefinitions();

        $this->info('Linking FSN');
        $this->linkFsn();
    }

    public function indexSnapDefinitions(): void
    {
        SnomedDescription::where('active', true)
            ->whereHas('snomedSnapConcept', fn(Builder $query) => $query->where('active', true))
            ->with(['snomedRefsetLanguage' => fn(HasMany $query) => $query->where('active', true)])
            ->chunk(1000, fn($rows) => $this->index($rows));
    }

    public function indexTextDefinitions(): void
    {
        SnomedTextDefinition::where('active', true)
            ->whereHas('snomedSnapConcept', fn(Builder $query) => $query->where('active', true))
            ->with(['snomedRefsetLanguage' => fn(HasMany $query) => $query->where('active', true)])
            ->chunk(1000, fn($rows) => $this->index($rows));
    }

    public function index(Collection $chunk): void
    {
        $records = collect([]);

        $chunk->each(function (SnomedDescription|SnomedTextDefinition $row) use ($records) {
            $semanticTag = null;
            if ($row->typeId == 900000000000003001) {
                preg_match('/\([a-zA-Z\/\s]*\)$/', $row->term, $match);
                if (count($match) != 0) {
                    $semanticTag = substr($match[0], 1, -1);
                    $row->term = preg_replace('/ ' . preg_quote($match[0], '/') . '$/', '', $row->term);
                }
            }

            $row->snomedRefsetLanguage->each(function (SnomedRefsetLanguage $refsetLanguage) use (
                $row,
                $semanticTag,
                $records
            ) {
                $records->push([
                    'id' => $row->id,
                    'concept_id' => $row->conceptId,
                    'type_id' => $row->typeId,
                    'term' => $row->term,
                    'refset_id' => $refsetLanguage->refsetId,
                    'semantic_tag' => $semanticTag,
                    'acceptability_id' => $refsetLanguage->acceptabilityId,
                ]);
            });
        });

        ImportSnomedJob::dispatch('snomed_indices', $records->toArray(), ['id'],
            ['concept_id', 'type_id', 'term', 'refset_id', 'acceptability_id', 'semantic_tag']);
    }

    public function linkFsn()
    {
        SnomedIndex::with('computedFullySpecifiedName')->chunkById(1000, function (Collection $indexes) {
            $records = $indexes->map(function (SnomedIndex $index) {
                $fsn = $index->computedFullySpecifiedName;

                if ($fsn != null) {
                    $index->fsn_id = $fsn->id;
                    $index->fsn_semantic_tag = $fsn->semantic_tag;
                }

                return $index->only(['id', 'fsn_id', 'fsn_semantic_tag']);
            });


            ImportSnomedJob::dispatch('snomed_indices', $records->toArray(), ['id'], ['fsn_id', 'fsn_semantic_tag']);
        });
    }
}
