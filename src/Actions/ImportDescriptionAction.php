<?php

namespace Threls\SnomedCTForLaravel\Actions;

use Illuminate\Support\Facades\Config;

class ImportDescriptionAction extends BaseImportAction
{
    protected static function getFile(): string
    {
        return Config::get('snomed-ct-for-laravel.import.files.description');
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

    protected static function upsertTable(): string
    {
        return 'snomed_snap_description';
    }

    protected static function upsertUniqueBy(): array
    {
        return ['id'];
    }

    protected static function upsertUpdate(): array
    {
        return [
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
