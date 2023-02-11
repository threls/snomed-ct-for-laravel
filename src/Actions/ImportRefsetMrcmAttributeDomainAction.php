<?php

namespace Threls\SnomedCTForLaravel\Actions;

use Illuminate\Support\Facades\Config;

class ImportRefsetMrcmAttributeDomainAction extends BaseImportAction
{
    protected static function upsertTable(): string
    {
        return 'snomed_snap_refset_mrcmAttributeDomain';
    }

    protected static function getFile(): string
    {
        return Config::get('snomed-ct-for-laravel.import.files.refsetMrcmAttributeDomain');
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
            'domainId' => $row[6],
            'grouped' => $row[7],
            'attributeCardinality' => $row[8],
            'attributeInGroupCardinality' => $row[9],
            'ruleStrengthId' => $row[10],
            'contentTypeId' => $row[11],
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
            'domainId',
            'grouped',
            'attributeCardinality',
            'attributeInGroupCardinality',
            'ruleStrengthId',
            'contentTypeId',
        ];
    }
}
