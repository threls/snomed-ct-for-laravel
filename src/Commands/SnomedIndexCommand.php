<?php

namespace Threls\SnomedCTForLaravel\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Threls\SnomedCTForLaravel\Models\SnomedSemanticTag;

class SnomedIndexCommand extends Command
{
    protected $signature = 'snomed:index';

    protected $description = 'Command description';

    protected Collection $semanticTags;

    public function __construct()
    {
        parent::__construct();
        $this->semanticTags = new Collection();
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
        DB::table('snomed_snap_description')
            ->join('snomed_snap_refset_language', 'snomed_snap_description.id', '=', 'snomed_snap_refset_language.referencedComponentId')
            ->where('snomed_snap_description.active', 1)
            ->where('snomed_snap_refset_language.active', 1)
            ->select('snomed_snap_description.id', 'snomed_snap_description.conceptId', 'snomed_snap_description.typeId', 'snomed_snap_description.term', 'snomed_snap_refset_language.refsetId', 'snomed_snap_refset_language.acceptabilityId')
            ->orderBy('snomed_snap_description.id')
            ->chunk(5000, fn ($rows) => $this->index($rows));
    }

    public function indexTextDefinitions()
    {
        DB::table('snomed_snap_textDefinition')
            ->join('snomed_snap_refset_language', 'snomed_snap_textDefinition.id', '=', 'snomed_snap_refset_language.referencedComponentId')
            ->where('snomed_snap_textDefinition.active', 1)
            ->where('snomed_snap_refset_language.active', 1)
            ->select('snomed_snap_textDefinition.id', 'snomed_snap_textDefinition.conceptId', 'snomed_snap_textDefinition.typeId', 'snomed_snap_textDefinition.term', 'snomed_snap_refset_language.refsetId', 'snomed_snap_refset_language.acceptabilityId')
            ->orderBy('snomed_snap_textDefinition.id')
            ->chunk(5000, fn ($rows) => $this->index($rows));
    }

    protected function getSemanticTagId(string $semanticTag)
    {
        $exists = $this->semanticTags->where('label', $semanticTag)->first();
        if ($exists != null) {
            return $exists->id;
        } else {
            $tag = SnomedSemanticTag::firstOrCreate(['label' => $semanticTag]);
            $this->semanticTags->push($tag);

            return $tag->id;
        }
    }

    public function index(Collection $chunk)
    {
        $records = $chunk->map(function ($row) {
            $semanticTagId = null;

            if ($row->typeId == 900000000000003001) {
                preg_match('#\((.*?)\)#', $row->term, $match);
                $semanticTagId = $this->getSemanticTagId($match[1]);
            }

            return [
                'id' => $row->id,
                'concept_id' => $row->conceptId,
                'type_id' => $row->typeId,
                'term' => $row->term,
                'refset_id' => $row->refsetId,
                'snomed_semantic_tag_id' => $semanticTagId,
                'acceptability_id' => $row->acceptabilityId,
            ];
        })->toArray();

        DB::table('snomed_index')->upsert($records, ['id'], ['concept_id', 'type_id', 'term', 'refset_id', 'acceptability_id', 'snomed_semantic_tag_id']);
    }
}
