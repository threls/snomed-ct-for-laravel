<?php

namespace Threls\SnomedCTForLaravel\Actions;

use Carbon\Carbon;

class ImportConceptAction extends BaseImportAction
{
    protected static function upsertTable(): string
    {
        return 'snomed_snap_concept';
    }

    protected static function getFile(string $folder, string $fileSuffix): string
    {
        return storage_path("app/snomed/{$folder}/Snapshot/Terminology/sct2_Concept_Snapshot_INT_{$fileSuffix}.txt");
    }

    protected static function map(array $row): array
    {
        return [
            'id' => $row[0],
            'effectiveTime' => Carbon::createFromFormat('Ymd', $row[1]),
            'active' => $row[2],
            'moduleId' => $row[3],
            'definitionStatusId' => $row[4],
        ];
    }

    protected static function upsertUpdate(): array
    {
        return ['effectiveTime', 'active', 'moduleId', 'definitionStatusId'];
    }
}
