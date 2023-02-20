<?php

namespace Threls\SnomedCTForLaravel\Actions;

use Illuminate\Support\Facades\Config;

class ImportRefsetSimpleAction extends BaseImportAction
{
    protected static function getFile(): string
    {
        return Config::get('snomed-ct-for-laravel.import.files.refsetSimple');
    }

    protected static function map(array $row): array
    {
        return [
            'id' => $row[0],
            'effectiveTime' => $row[1],
            'active' => $row[2],
            'moduleId' => $row[3],
            'refsetId' => $row[4],
            'referencedComponentId' => $row[4],
        ];
    }

    protected static function upsertTable(): string
    {
        return 'snomed_snap_refset_simple';
    }

    protected static function upsertUpdate(): array
    {
        return ['effectiveTime', 'active', 'moduleId', 'refsetId', 'referencedComponentId'];
    }
}
