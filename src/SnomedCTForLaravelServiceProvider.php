<?php

namespace Threls\SnomedCTForLaravel;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Threls\SnomedCTForLaravel\Commands\ImportCommand;
use Threls\SnomedCTForLaravel\Commands\PersistCommand;
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
                'create_snomed_temp_tables',
                'create_snomed_persisted_table',
            ])->runsMigrations()
            ->hasCommands([
                ImportCommand::class,
                SnomedIndexCommand::class,
                PersistCommand::class,
            ])->hasConfigFile();
    }
}
