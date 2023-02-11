<?php

namespace Threls\SnomedCTForLaravel\Actions;

use Illuminate\Support\Facades\Config;

class ImportRelationshipAction extends BaseImportAction
{
    protected static function getFile(): string
    {
        return Config::get('snomed-ct-for-laravel.import.files.relationship');

    }

    protected static function map(array $row): array
    {
        return [
            'id' => $row[0],
            'effectiveTime' => $row[1],
            'active' => $row[2],
            'moduleId' => $row[3],
            'sourceId' => $row[4],
            'destinationId' => $row[5],
            'relationshipGroup' => $row[6],
            'typeId' => $row[7],
            'characteristicTypeId' => $row[8],
            'modifierId' => $row[9],
        ];
    }

    protected static function upsertTable(): string
    {
        return 'snomed_snap_relationship';
    }

    protected static function upsertUpdate(): array
    {
        return ['effectiveTime', 'active', 'moduleId', 'sourceId', 'destinationId', 'relationshipGroup', 'typeId', 'characteristicTypeId', 'modifierId'];
    }
}
