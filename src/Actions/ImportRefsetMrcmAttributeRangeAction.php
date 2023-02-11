<?php

namespace Threls\SnomedCTForLaravel\Actions;

use Illuminate\Support\Facades\Config;

class ImportRefsetMrcmAttributeRangeAction extends BaseImportAction
{
    protected static function getFile(): string
    {
        return Config::get('snomed-ct-for-laravel.import.files.refsetMrcmAttributeRange');
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
            'rangeConstraint' => $row[6],
            'attributeRule' => $row[7],
            'ruleStrengthId' => $row[8],
            'contentTypeId' => $row[9],
        ];
    }

    protected static function upsertTable(): string
    {
        return 'snomed_snap_refset_mrcmAttributeRange';
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
            'rangeConstraint',
            'attributeRule',
            'ruleStrengthId',
            'contentTypeId',
        ];
    }
}
