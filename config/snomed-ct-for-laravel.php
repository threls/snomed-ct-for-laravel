<?php

// config for Threls/SnomedCTForLaravel
return [
    'models' => [
        'index' => \Threls\SnomedCTForLaravel\Models\SnomedIndex::class,
        'semantic_tag' => \Threls\SnomedCTForLaravel\Models\SnomedSemanticTag::class
    ],
    'import' => [
        'files' => [
            'concept' => env('SNOMED_IMPORT_CONCEPT', base_path('data/SnomedCT_InternationalRF2_PRODUCTION_20230131T120000Z/Snapshot/Terminology/sct2_Concept_Snapshot_INT_20230131.txt')),
            'description' => env('SNOMED_IMPORT_DESCRIPTION', base_path('data/SnomedCT_InternationalRF2_PRODUCTION_20230131T120000Z/Snapshot/Terminology/sct2_Description_Snapshot-en_INT_20230131.txt')),
            'refsetAssociation' => env('SNOMED_IMPORT_REFSET_ASSOCIATION', base_path('data/SnomedCT_InternationalRF2_PRODUCTION_20230131T120000Z/Snapshot/Refset/Content/der2_cRefset_AssociationSnapshot_INT_20230131.txt')),
            'refsetAttributeValue' => env('SNOMED_IMPORT_REFSET_ATTRIBUTE_VALUE', base_path('data/SnomedCT_InternationalRF2_PRODUCTION_20230131T120000Z/Snapshot/Refset/Content/der2_cRefset_AttributeValueSnapshot_INT_20230131.txt')),
            'refsetDescriptionType' => env('SNOMED_IMPORT_REFSET_DESCRIPTION_TYPE', base_path('data/SnomedCT_InternationalRF2_PRODUCTION_20230131T120000Z/Snapshot/Refset/Metadata/der2_ciRefset_DescriptionTypeSnapshot_INT_20230131.txt')),
            'refsetExtended' => env('SNOMED_IMPORT_REFSET_EXTENDED', base_path('data/SnomedCT_InternationalRF2_PRODUCTION_20230131T120000Z/Snapshot/Refset/Map/der2_iisssccRefset_ExtendedMapSnapshot_INT_20230131.txt')),
            'refsetLanguage' => env('SNOMED_IMPORT_REFSET_LANGUAGE', base_path('data/SnomedCT_InternationalRF2_PRODUCTION_20230131T120000Z/Snapshot/Refset/Language/der2_cRefset_LanguageSnapshot-en_INT_20230131.txt')),
            'refsetModuleDependency' => env('SNOMED_IMPORT_REFSET_MODULE_DEPENDENCY', base_path('data/SnomedCT_InternationalRF2_PRODUCTION_20230131T120000Z/Snapshot/Refset/Metadata/der2_ssRefset_ModuleDependencySnapshot_INT_20230131.txt')),
            'refsetMrcmAttributeDomain' => env('SNOMED_IMPORT_REFSET_MRCM_ATTRIBUTE_DOMAIN', base_path('data/SnomedCT_InternationalRF2_PRODUCTION_20230131T120000Z/Snapshot/Refset/Metadata/der2_cissccRefset_MRCMAttributeDomainSnapshot_INT_20230131.txt')),
            'refsetMrcmAttributeRange' => env('SNOMED_IMPORT_REFSET_MRCM_ATTRIBTUE_RANGE', base_path('data/SnomedCT_InternationalRF2_PRODUCTION_20230131T120000Z/Snapshot/Refset/Metadata/der2_ssccRefset_MRCMAttributeRangeSnapshot_INT_20230131.txt')),
            'refsetMrcmDomain' => env('SNOMED_IMPORT_REFSET_MRCM_DOMAIN', base_path('data/SnomedCT_InternationalRF2_PRODUCTION_20230131T120000Z/Snapshot/Refset/Metadata/der2_sssssssRefset_MRCMDomainSnapshot_INT_20230131.txt')),
            'refsetMrcmModuleScope' => env('SNOMED_IMPORT_REFSET_MRCM_MODULE_SCOPE', base_path('data/SnomedCT_InternationalRF2_PRODUCTION_20230131T120000Z/Snapshot/Refset/Metadata/der2_cRefset_MRCMModuleScopeSnapshot_INT_20230131.txt')),
            'refsetOwlExpression' => env('SNOMED_IMPORT_REFSET_OWL_EXPRESSION', base_path('data/SnomedCT_InternationalRF2_PRODUCTION_20230131T120000Z/Snapshot/Terminology/sct2_sRefset_OWLExpressionSnapshot_INT_20230131.txt')),
            'refsetRefsetDescriptor' => env('SNOMED_IMPORT_REFSET_REFSET_DESCRIPTOR', base_path('data/SnomedCT_InternationalRF2_PRODUCTION_20230131T120000Z/Snapshot/Refset/Metadata/der2_cciRefset_RefsetDescriptorSnapshot_INT_20230131.txt')),
            'refsetSimple' => env('SNOMED_IMPORT_REFSET_SIMPLE', base_path('data/SnomedCT_InternationalRF2_PRODUCTION_20230131T120000Z/Snapshot/Refset/Content/der2_Refset_SimpleSnapshot_INT_20230131.txt')),
            'refsetSimpleMap' => env('SNOMED_IMPORT_REFSET_SIMPLE_MAP', base_path('data/SnomedCT_InternationalRF2_PRODUCTION_20230131T120000Z/Snapshot/Refset/Map/der2_sRefset_SimpleMapSnapshot_INT_20230131.txt')),
            'relationship' => env('SNOMED_IMPORT_RELATIONSHIP', base_path('data/SnomedCT_InternationalRF2_PRODUCTION_20230131T120000Z/Snapshot/Terminology/sct2_Relationship_Snapshot_INT_20230131.txt')),
            'statedRelationship' => env('SNOMED_IMPORT_STATED_RELATIONSHIP', base_path('data/SnomedCT_InternationalRF2_PRODUCTION_20230131T120000Z/Snapshot/Terminology/sct2_StatedRelationship_Snapshot_INT_20230131.txt')),
            'textDefinition' => env('SNOMED_IMPORT_TEXT_DEFINITION', base_path('data/SnomedCT_InternationalRF2_PRODUCTION_20230131T120000Z/Snapshot/Terminology/sct2_TextDefinition_Snapshot-en_INT_20230131.txt')),
        ]
    ]
];
