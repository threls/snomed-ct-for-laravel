<?php

namespace Threls\SnomedCTForLaravel\Actions;

use Illuminate\Support\Facades\Config;

class ImportRefsetModuleDependencyAction extends BaseImportAction
{
    protected static function getFile(): string
    {
        return Config::get('snomed-ct-for-laravel.import.files.refsetModuleDependency');
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
            'sourceEffectiveTime' => $row[6],
            'targetEffectiveTime' => $row[7],
        ];
    }

    protected static function upsertTable(): string
    {
        return 'snomed_snap_refset_moduleDependency';
    }

    protected static function upsertUpdate(): array
    {
        return ['effectiveTime', 'active', 'moduleId', 'refsetId', 'referencedComponentId', 'sourceEffectiveTime', 'targetEffectiveTime'];
    }
}
