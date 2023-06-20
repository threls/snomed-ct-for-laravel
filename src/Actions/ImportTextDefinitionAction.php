<?php

namespace Threls\SnomedCTForLaravel\Actions;

use Carbon\Carbon;

class ImportTextDefinitionAction extends BaseImportAction
{
    protected static function upsertTable(): string
    {
        return 'snomed_text_definition';
    }

    protected static function getFile(string $folder, string $fileSuffix): string
    {
        return storage_path("app/snomed/{$folder}/Snapshot/Terminology/sct2_TextDefinition_Snapshot-en_INT_${fileSuffix}.txt");
    }

    protected static function map(array $row): array
    {
        return [
            'id'                 => $row[0],
            'effectiveTime'      => Carbon::createFromFormat('Ymd', $row[1]),
            'active'             => $row[2],
            'moduleId'           => $row[3],
            'conceptId'          => $row[4],
            'languageCode'       => $row[5],
            'typeId'             => $row[6],
            'term'               => $row[7],
            'caseSignificanceId' => $row[8],
        ];
    }

    protected static function upsertUpdate(): array
    {
        return [
            'id',
            'effectiveTime',
            'active',
            'moduleId',
            'conceptId',
            'languageCode',
            'typeId',
            'term',
            'caseSignificanceId',
        ];
    }
}
