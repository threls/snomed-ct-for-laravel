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
                'create_snomed_description_table',
                'create_snomed_refset_languages_table',
                'create_snomed_text_definition_table',
                'create_snomed_indices_table',
                'change_id_to_uuid_of_refset_language',
                'create_snomed_snap_concept_table',
                'add_fsn_to_snomed_indices',
            ])->runsMigrations()
            ->hasCommands([
                ImportCommand::class,
                SnomedIndexCommand::class,
            ])->hasConfigFile();
    }
}
