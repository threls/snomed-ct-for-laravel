<?php

namespace Threls\SnomedCTForLaravel\Commands;

use Illuminate\Console\Command;
use Threls\SnomedCTForLaravel\Actions\ImportConceptAction;
use Threls\SnomedCTForLaravel\Actions\ImportDescriptionAction;
use Threls\SnomedCTForLaravel\Actions\ImportRefsetAssociationAction;
use Threls\SnomedCTForLaravel\Actions\ImportRefsetAttributeValueAction;
use Threls\SnomedCTForLaravel\Actions\ImportRefsetDescriptionTypeAction;
use Threls\SnomedCTForLaravel\Actions\ImportRefsetExtendedAction;
use Threls\SnomedCTForLaravel\Actions\ImportRefsetLanguageAction;
use Threls\SnomedCTForLaravel\Actions\ImportRefsetModuleDependencyAction;
use Threls\SnomedCTForLaravel\Actions\ImportRefsetMrcmAttributeDomainAction;
use Threls\SnomedCTForLaravel\Actions\ImportRefsetMrcmAttributeRangeAction;
use Threls\SnomedCTForLaravel\Actions\ImportRefsetMrcmDomainAction;
use Threls\SnomedCTForLaravel\Actions\ImportRefsetMrcmModuleScopeAction;
use Threls\SnomedCTForLaravel\Actions\ImportRefsetOwlExpressionAction;
use Threls\SnomedCTForLaravel\Actions\ImportRefsetRefsetDescriptorAction;
use Threls\SnomedCTForLaravel\Actions\ImportRefsetSimpleAction;
use Threls\SnomedCTForLaravel\Actions\ImportRefsetSimpleMapAction;
use Threls\SnomedCTForLaravel\Actions\ImportRelationshipAction;
use Threls\SnomedCTForLaravel\Actions\ImportStatedRelationshipAction;
use Threls\SnomedCTForLaravel\Actions\ImportTextDefinitionAction;

class ImportCommand extends Command
{
    protected $signature = 'snomed:import';

    protected $description = 'Command description';

    public function handle()
    {
        $this->info('Importing Concepts');
        app(ImportConceptAction::class)->execute();

        $this->info('Importing Description');
        app(ImportDescriptionAction::class)->execute();

        $this->info('Importing Refset Language');
        app(ImportRefsetLanguageAction::class)->execute();

        $this->info('Importing Relationship');
        app(ImportRelationshipAction::class)->execute();

        $this->info('Importing Refset Simple');
        app(ImportRefsetSimpleAction::class)->execute();

        $this->info('Importing Refset Extended');
        app(ImportRefsetExtendedAction::class)->execute();

        $this->info('Importing Refset Module Dependency');
        app(ImportRefsetModuleDependencyAction::class)->execute();

        $this->info('Importing Refset Association');
        app(ImportRefsetAssociationAction::class)->execute();

        $this->info('Importing Refset Attribute Value');
        app(ImportRefsetAttributeValueAction::class)->execute();

        $this->info('Importing Refset Description Type');
        app(ImportRefsetDescriptionTypeAction::class)->execute();

        $this->info('ImportRefsetMrcmAttributeDomainCommand');
        app(ImportRefsetMrcmAttributeDomainAction::class)->execute();

        $this->info('ImportRefsetMrcmAttributeRange');
        app(ImportRefsetMrcmAttributeRangeAction::class)->execute();

        $this->info('ImportRefsetMrcmDomainCommand');
        app(ImportRefsetMrcmDomainAction::class)->execute();

        $this->info('ImportRefsetMrcmModuleScopeCommand');
        app(ImportRefsetMrcmModuleScopeAction::class)->execute();

        $this->info('ImportRefsetOwlExpression');
        app(ImportRefsetOwlExpressionAction::class)->execute();

        $this->info('ImportRefsetRefsetDescriptor');
        app(ImportRefsetRefsetDescriptorAction::class)->execute();

        $this->info('ImportRefsetSimpleMapCommand');
        app(ImportRefsetSimpleMapAction::class)->execute();

        $this->info('ImportStatedRelationship');
        app(ImportStatedRelationshipAction::class)->execute();

        $this->info('ImportTextDefinition');
        app(ImportTextDefinitionAction::class)->execute();
    }
}
