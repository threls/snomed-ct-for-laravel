<?php

namespace Threls\SnomedCTForLaravel\Actions;

use Illuminate\Support\Facades\Config;

class ImportRefsetMrcmModuleScopeAction extends BaseImportAction
{
    protected static function upsertTable(): string
    {
        return 'snomed_snap_refset_mrcmModuleScope';
    }

    protected static function getFile(): string
    {
        return Config::get('snomed-ct-for-laravel.import.files.refsetMrcmModuleScope');
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
            'mrcmRuleRefsetId' => $row[6],
        ];
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
            'mrcmRuleRefsetId',
        ];
    }
}
