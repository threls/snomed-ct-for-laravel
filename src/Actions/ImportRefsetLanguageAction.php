<?php

namespace Threls\SnomedCTForLaravel\Actions;

use Carbon\Carbon;

class ImportRefsetLanguageAction extends BaseImportAction
{
    protected static function getFile(string $folder, string $fileSuffix): string
    {
        return storage_path("app/snomed/{$folder}/Snapshot/Refset/Language/der2_cRefset_LanguageSnapshot-en_INT_${fileSuffix}.txt");
    }

    protected static function map(array $row): array
    {
        return [
            'id' => $row[0],
            'effectiveTime' => Carbon::createFromFormat('Ymd', $row[1]),
            'active' => $row[2],
            'moduleId' => $row[3],
            'refsetId' => $row[4],
            'referencedComponentId' => $row[5],
            'acceptabilityId' => $row[6],

        ];
    }

    protected static function upsertTable(): string
    {
        return 'snomed_refset_language';
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
            'refsetId',
            'referencedComponentId',
            'acceptabilityId',

        ];
    }
}
