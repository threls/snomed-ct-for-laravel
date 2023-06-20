<?php

use Threls\SnomedCTForLaravel\Models\SnomedIndex;

/**
 * Here you can define the config for Threls/SnomedCTForLaravel.
 */

return [
    'models' => [
        'index' => SnomedIndex::class,
    ],
    'db'     => [
        'temp' => [
            'connection' => env('SNOMED_TEMP_CONNECTION', 'sqlite')
        ],
        'persisted' => [
            'connection' => env('SNOMED_TEMP_CONNECTION', 'mysql')
        ]
    ]
];
