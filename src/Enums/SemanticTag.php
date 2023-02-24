<?php

namespace Threls\SnomedCTForLaravel\Enums;

enum SemanticTag: string
{
    case OWL_METADATA_CONCEPT = 'OWL metadata concept';
    case ADMINISTRATION_METHOD = 'administration method';
    case ASSESSMENT_SCALE = 'assessment scale';
    case ATTRIBUTE = 'attribute';
    case BASIC_DOSE_FORM = 'basic dose form';
    case BODY_STRUCTURE = 'body structure';
    case CELL = 'cell';
    case CELL_STRUCTURE = 'cell structure';
    case CLINICAL_DRUG = 'clinical drug';
    case CORE_METADATA_CONCEPT = 'core metadata concept';
    case DISORDER = 'disorder';
    case DISPOSITION = 'disposition';
    case DOSE_FORM = 'dose form';
    case ENVIRONMENT = 'environment';
    case ETHNIC_GROUP = 'ethnic group';
    case EVENT = 'event';
    case FINDING = 'finding';
    case FOUNDATION_METADATA_CONCEPT = 'foundation metadata concept';
    case GEOGRAPHIC_LOCATION = 'geographic location';
    case INACTIVE_CONCEPT = 'inactive concept';
    case INTENDED_SITE = 'intended site';
    case LIFE_STYLE = 'life style';
    case LINK_ASSERTION = 'link assertion';
    case LINKAGE_CONCEPT = 'linkage concept';
    case MEDICINAL_PRODUCT = 'medicinal product';
    case MEDICINAL_PRODUCT_FORM = 'medicinal product form';
    case MORPHOLOGIC_ABNORMALITY = 'morphologic abnormality';
    case NAMESPACE_CONCEPT = 'namespace concept';
    case NAVIGATIONAL_CONCEPT = 'navigational concept';
    case NUMBER = 'number';
    case OBSERVABLE_ENTITY = 'observable entity';
    case OCCUPATION = 'occupation';
    case ORGANISM = 'organism';
    case PERSON = 'person';
    case PHYSICAL_FORCE = 'physical force';
    case PHYSICAL_OBJECT = 'physical object';
    case PROCEDURE = 'procedure';
    case PRODUCT = 'product';
    case PRODUCT_NAME = 'product name';
    case QUALIFIER_VALUE = 'qualifier value';
    case RACIAL_GROUP = 'racial group';
    case RECORD_ARTIFACT = 'record artifact';
    case REGIME_THERAPY = 'regime/therapy';
    case RELEASE_CHARACTERISTIC = 'release characteristic';
    case RELIGION_PHILOSOPHY = 'religion/philosophy';
    case ROLE = 'role';
    case SITUATION = 'situation';
    case SOCIAL_CONCEPT = 'social concept';
    case SPECIMEN = 'specimen';
    case STAGING_SCALE = 'staging scale';
    case STATE_OF_MATTER = 'state of matter';
    case SUBSTANCE = 'substance';
    case SUPPLIER = 'supplier';
    case TRANSFORMATION = 'transformation';
    case TUMOR_STAGING = 'tumor staging';
    case UNIT_OF_PRESENTATION = 'unit of presentation';
}
