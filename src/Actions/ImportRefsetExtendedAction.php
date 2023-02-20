<?php

namespace Threls\SnomedCTForLaravel\Actions;

use Illuminate\Support\Facades\Config;

class ImportRefsetExtendedAction extends BaseImportAction
{
    protected static function getFile(): string
    {
        return Config::get('snomed-ct-for-laravel.import.files.refsetExtended');
    }

    protected static function map(array $row): array
    {
        return [
            'id' => $row[0],
            'effectiveTime' => $row[1],
            'active' => $row[2],
            'moduleId' => $row[3],
            'refsetId' => $row[4],
            'referencedComponentId' => $row[5],
            'mapGroup' => $row[6],
            'mapPriority' => $row[7],
            'mapRule' => $row[8],
            'mapAdvice' => $row[9],
            'mapTarget' => $row[10],
            'correlationId' => $row[11],
            'mapCategoryId' => $row[12],
        ];
    }

    protected static function upsertTable(): string
    {
        return 'snomed_snap_refset_extendedMap';
    }

    protected static function upsertUpdate(): array
    {
        return [
            'id',
            'effectiveTime',
            'active',
            'moduleId',
            'refsetId',
            'referencedComponentId',
            'mapGroup',
            'mapPriority',
            'mapRule',
            'mapAdvice',
            'mapTarget',
            'correlationId',
            'mapCategoryId',
        ];
    }
}
