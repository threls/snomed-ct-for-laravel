<?php

namespace Threls\SnomedCTForLaravel\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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
        $this->info('Indexing Snap Definitions');
        $this->indexSnapDefinitions();

        $this->info('Indexing Text Definitions');
        $this->indexTextDefinitions();
    }

    public function indexSnapDefinitions()
    {
        DB::table('snomed_description')
            ->join('snomed_refset_language', 'snomed_description.id', '=', 'snomed_refset_language.referencedComponentId')
            ->where('snomed_description.active', 1)
            ->where('snomed_refset_language.active', 1)
            ->select('snomed_description.id', 'snomed_description.conceptId', 'snomed_description.typeId', 'snomed_description.term', 'snomed_refset_language.refsetId', 'snomed_refset_language.acceptabilityId')
            ->orderBy('snomed_description.id')
            ->chunk(5000, fn ($rows) => $this->index($rows));
    }

    public function indexTextDefinitions()
    {
        DB::table('snomed_textDefinition')
            ->join('snomed_refset_language', 'snomed_textDefinition.id', '=', 'snomed_refset_language.referencedComponentId')
            ->where('snomed_textDefinition.active', 1)
            ->where('snomed_refset_language.active', 1)
            ->select('snomed_textDefinition.id', 'snomed_textDefinition.conceptId', 'snomed_textDefinition.typeId', 'snomed_textDefinition.term', 'snomed_refset_language.refsetId', 'snomed_refset_language.acceptabilityId')
            ->orderBy('snomed_textDefinition.id')
            ->chunk(5000, fn ($rows) => $this->index($rows));
    }

    public function index(Collection $chunk)
    {
        $records = $chunk->map(function ($row) {
            $semanticTag = null;
            if ($row->typeId == 900000000000003001) {
                preg_match('/\([a-zA-Z\/\s]*\)$/', $row->term, $match);
                if (count($match) != 0) {
                    $semanticTag = substr($match[0], 1, -1);
                }
            }

            return [
                'id' => $row->id,
                'concept_id' => $row->conceptId,
                'type_id' => $row->typeId,
                'term' => $row->term,
                'refset_id' => $row->refsetId,
                'semantic_tag' => $semanticTag,
                'acceptability_id' => $row->acceptabilityId,
            ];
        })->toArray();

        DB::table('snomed_index')->upsert($records, ['id'], ['concept_id', 'type_id', 'term', 'refset_id', 'acceptability_id', 'semantic_tag']);
    }
}
