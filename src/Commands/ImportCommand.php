<?php

namespace Threls\SnomedCTForLaravel\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Threls\SnomedCTForLaravel\Actions\ImportConceptAction;
use Threls\SnomedCTForLaravel\Actions\ImportDescriptionAction;
use Threls\SnomedCTForLaravel\Actions\ImportRefsetLanguageAction;
use Threls\SnomedCTForLaravel\Actions\ImportTextDefinitionAction;
use Threls\SnomedCTForLaravel\Actions\SnomedMetaActions;
use ZipArchive;

class ImportCommand extends Command
{
    protected $signature = 'snomed:import';

    protected $description = 'Import snomed data to database';

    protected string $selectedZipFile;

    protected Carbon $updatedTimestamp;

    public function handle()
    {
        $files = Storage::files('snomed');
        $this->selectedZipFile = $this->choice('Select File', $files);
        $this->updatedTimestamp = $this->getUpdatedTimestamp();

        $prevReleaseEffectiveTime = app(SnomedMetaActions::class)->getReleaseEffectiveTime();

        if (! is_null($prevReleaseEffectiveTime) && $prevReleaseEffectiveTime->greaterThanOrEqualTo($this->updatedTimestamp->copy()->startOfDay())) {
            $this->error('You are using an older version. No updates will be effected.');

            return;
        }

        $this->info("Previous Release Effective Time: {$prevReleaseEffectiveTime?->toDateString()}");
        $this->info("New Release Effective Time: {$this->updatedTimestamp->toDateString()}");

        $confirmation = $this->confirm('Confirm', true);
        if (! $confirmation) {
            return;
        }

        $this->info('Extracting Zip');
        $this->extractZip();

        $this->info('Importing Concepts');
        app(ImportConceptAction::class)->execute($this->updatedTimestamp, $prevReleaseEffectiveTime);

        $this->info('Importing Description');
        app(ImportDescriptionAction::class)->execute($this->updatedTimestamp, $prevReleaseEffectiveTime);

        $this->info('Importing Refset Language');
        app(ImportRefsetLanguageAction::class)->execute($this->updatedTimestamp, $prevReleaseEffectiveTime);

        $this->info('ImportTextDefinition');
        app(ImportTextDefinitionAction::class)->execute($this->updatedTimestamp, $prevReleaseEffectiveTime);

        $this->info('Setting Release Effective Time');
        app(SnomedMetaActions::class)->setReleaseEffectiveTime($this->updatedTimestamp);
    }

    public function getUpdatedTimestamp(): Carbon
    {
        $re = '/(?<=_)\w{16}(?=\.zip$)/';
        preg_match($re, $this->selectedZipFile, $matches, PREG_OFFSET_CAPTURE, 0);

        return Carbon::parse($matches[0][0]);
    }

    public function extractZip(): void
    {
        $zipPath = storage_path("app/{$this->selectedZipFile}");
        $extractPath = storage_path('app/snomed');

        $zipArchive = new ZipArchive;
        $res = $zipArchive->open($zipPath);

        if ($res === false) {
            $this->error('Extract cannot be completed');

            return;
        }

        $zipArchive->extractTo($extractPath);
    }
}
