<?php

namespace Threls\SnomedCTForLaravel;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Threls\SnomedCTForLaravel\Commands\ImportCommand;
use Threls\SnomedCTForLaravel\Commands\SnomedIndexCommand;

class SnomedCTForLaravelServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('snomed-ct-for-laravel')
            ->hasMigrations([
                'create_snomed_snap_concept_table',
                'create_snomed_snap_description_table',
                'create_snomed_snap_refset_languages_table',
                'create_snomed_snap_relationship_table',
                'create_snomed_snap_refset_simple_table',
                'create_snomed_snap_refset_extended_map_table',
                'create_snomed_snap_refset_module_dependency_table',
                'create_snomed_snap_refset_association_table',
                'create_snomed_snap_refset_attribute_value_table',
                'create_snomed_snap_refset_description_type_table',
                'create_snomed_snap_refset_mrcm_attribute_domain_table',
                'create_snomed_snap_refset_mrcm_attribute_range_table',
                'create_snomed_snap_refset_mrcm_domain_table',
                'create_snomed_snap_refset_mrcm_module_scope_table',
                'create_snomed_snap_refset_owl_expression_table',
                'create_snomed_snap_refset_refset_descriptor_table',
                'create_snomed_snap_refset_simple_map_table',
                'create_snomed_snap_stated_relationship_table',
                'create_snomed_text_definition_table',
                'create_snomed_indices_table',
            ])->runsMigrations()
            ->hasCommands([
                ImportCommand::class,
                SnomedIndexCommand::class,
            ])->hasConfigFile();
    }
}
