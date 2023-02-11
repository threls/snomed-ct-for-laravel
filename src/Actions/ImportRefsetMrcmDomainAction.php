<?php

namespace Threls\SnomedCTForLaravel\Actions;

use Illuminate\Support\Facades\Config;

class ImportRefsetMrcmDomainAction extends BaseImportAction
{
    protected static function upsertTable(): string
    {
        return 'snomed_snap_refset_mrcmDomain';
    }

    protected static function getFile(): string
    {
        return Config::get('snomed-ct-for-laravel.import.files.refsetMrcmDomain');
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

            'domainConstraint' => $row[6],
            'parentDomain' => $row[7],
            'proximalPrimitiveConstraint' => $row[8],
            'proximalPrimitiveRefinement' => $row[9],
            'domainTemplateForPrecoordination' => $row[10],
            'domainTemplateForPostcoordination' => $row[11],
            'guideURL' => $row[12],
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

            'domainConstraint',
            'parentDomain',
            'proximalPrimitiveConstraint',
            'proximalPrimitiveRefinement',
            'domainTemplateForPrecoordination',
            'domainTemplateForPostcoordination',
            'guideURL',
        ];
    }
}
