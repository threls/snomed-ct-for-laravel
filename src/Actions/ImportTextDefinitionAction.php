<?php

namespace Threls\SnomedCTForLaravel\Actions;

use Illuminate\Support\Facades\Config;

class ImportTextDefinitionAction extends BaseImportAction
{
    protected static function upsertTable(): string
    {
        return 'snomed_snap_textDefinition';
    }

    protected static function getFile(): string
    {
        return Config::get('snomed-ct-for-laravel.import.files.textDefinition');
    }

    protected static function map(array $row): array
    {
        return [
            'id' => $row[0],
            'effectiveTime' => $row[1],
            'active' => $row[2],
            'moduleId' => $row[3],
            'conceptId' => $row[4],
            'languageCode' => $row[5],
            'typeId' => $row[6],
            'term' => $row[7],
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
