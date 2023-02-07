<?php

namespace Threls\SnomedCTForLaravel;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Threls\SnomedCTForLaravel\Commands\SnomedCTForLaravelCommand;

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
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_snomed-ct-for-laravel_table')
            ->hasCommand(SnomedCTForLaravelCommand::class);
    }
}
