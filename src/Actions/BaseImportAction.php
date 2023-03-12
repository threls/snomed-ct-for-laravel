<?php

namespace Threls\SnomedCTForLaravel\Actions;

use Illuminate\Support\Benchmark;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;
use Threls\SnomedCTForLaravel\Jobs\ImportSnomedJob;

abstract class BaseImportAction
{
    abstract protected static function upsertTable(): string;

    abstract protected static function getFile(): string;

    abstract protected static function map(array $row): array;

    abstract protected static function upsertUpdate(): array;

    protected static function upsertUniqueBy(): array
    {
        return ['id'];
    }

    final public function execute(): void
    {
        LazyCollection::make(function () {
            $handle = fopen($this->getFile(), 'r');

            while (($row = fgets($handle, null)) !== false) {
                yield explode("\t", trim($row, "\r\n"));
            }

            fclose($handle);
        })
            ->skip(1)
            ->chunk(5000)
            ->each(function (LazyCollection $chunk) {
                $records = $chunk->map(function ($row) {
                    return $this->map($row);
                })->toArray();

                ImportSnomedJob::dispatch($this->upsertTable(), $records, $this->upsertUniqueBy(), $this->upsertUpdate());
            });
    }
}
