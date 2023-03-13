<?php

use Threls\SnomedCTForLaravel\Models\SnomedIndex;

/**
 * Here you can define the config for Threls/SnomedCTForLaravel.
 */

return [
    'models' => [
        'index' => SnomedIndex::class,
    ],
    'import' => [
        'files' => [
            'concept' => env('SNOMED_IMPORT_CONCEPT', base_path('data/SnomedCT_InternationalRF2_PRODUCTION_20230131T120000Z/Snapshot/Terminology/sct2_Concept_Snapshot_INT_20230131.txt')),
            'description' => env('SNOMED_IMPORT_DESCRIPTION', base_path('data/SnomedCT_InternationalRF2_PRODUCTION_20230131T120000Z/Snapshot/Terminology/sct2_Description_Snapshot-en_INT_20230131.txt')),
            'refsetLanguage' => env('SNOMED_IMPORT_REFSET_LANGUAGE', base_path('data/SnomedCT_InternationalRF2_PRODUCTION_20230131T120000Z/Snapshot/Refset/Language/der2_cRefset_LanguageSnapshot-en_INT_20230131.txt')),
            'textDefinition' => env('SNOMED_IMPORT_TEXT_DEFINITION', base_path('data/SnomedCT_InternationalRF2_PRODUCTION_20230131T120000Z/Snapshot/Terminology/sct2_TextDefinition_Snapshot-en_INT_20230131.txt')),
        ],
    ],
];
