<?php

namespace Threls\SnomedCTForLaravel\Actions;

use Illuminate\Support\Facades\Config;

class ImportRefsetAssociationAction extends BaseImportAction
{
    protected static function getFile(): string
    {
        return Config::get('snomed-ct-for-laravel.import.files.refsetAssociation');
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
            'targetComponentId' => $row[6],
        ];
    }

    protected static function upsertTable(): string
    {
        return 'snomed_snap_refset_association';
    }

    protected static function upsertUpdate(): array
    {
        return ['effectiveTime', 'active', 'moduleId', 'refsetId', 'referencedComponentId', 'targetComponentId'];
    }
}
