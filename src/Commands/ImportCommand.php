<?php

namespace Threls\SnomedCTForLaravel\Commands;

use Illuminate\Console\Command;
use Threls\SnomedCTForLaravel\Actions\ImportConceptAction;
use Threls\SnomedCTForLaravel\Actions\ImportDescriptionAction;
use Threls\SnomedCTForLaravel\Actions\ImportRefsetLanguageAction;
use Threls\SnomedCTForLaravel\Actions\ImportTextDefinitionAction;

class ImportCommand extends Command
{
    protected $signature = 'snomed:import';

    protected $description = 'Import snomed data to database';

    public function handle()
    {
        $this->info('Importing Concepts');
        app(ImportConceptAction::class)->execute();

        $this->info('Importing Description');
        app(ImportDescriptionAction::class)->execute();

        $this->info('Importing Refset Language');
        app(ImportRefsetLanguageAction::class)->execute();

        $this->info('ImportTextDefinition');
        app(ImportTextDefinitionAction::class)->execute();
    }
}
