<?php

namespace Threls\SnomedCTForLaravel\Actions;

use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;

abstract class BaseImportAction
{
    abstract protected static function upsertTable(): string;

    abstract protected static function getFile(string $folder, string $fileSuffix): string;

    abstract protected static function map(array $row): array;

    abstract protected static function upsertUpdate(): array;

    protected static function upsertUniqueBy(): array
    {
        return ['id'];
    }

    protected static function getFolderName(Carbon $zipUpdateTimestamp): string
    {
        return "SnomedCT_InternationalRF2_PRODUCTION_{$zipUpdateTimestamp->format('Ymd\THis\Z')}";
    }

    protected static function getFileNameSuffix(Carbon $zipUpdateTimestamp): string
    {
        return $zipUpdateTimestamp->format('Ymd');
    }

    protected static function getFilePath(Carbon $zipUpdateTimestamp): string
    {
        $folder = self::getFolderName($zipUpdateTimestamp);
        $suffix = self::getFileNameSuffix($zipUpdateTimestamp);

        return static::getFile($folder, $suffix);
    }

    final public function execute(Carbon $zipUpdateTimestamp, ?Carbon $since): void
    {
        LazyCollection::make(function () use ($zipUpdateTimestamp) {
            $handle = fopen($this->getFilePath($zipUpdateTimestamp), 'r');

            while (($row = fgets($handle, null)) !== false) {
                yield explode("\t", trim($row, "\r\n"));
            }

            fclose($handle);
        })
            ->skip(1)
            ->chunk(5000)
            ->each(function (LazyCollection $chunk) use ($since) {
                $records = $chunk->map(function ($row) use ($since) {
                    $map = $this->map($row);

                    if (is_null($since)) {
                        return $map;
                    } elseif ($since->greaterThanOrEqualTo($map['effectiveTime']->startOfDay())) {
                        return null;
                    } else {
                        return $map;
                    }
                })->filter()->toArray();

                DB::connection($this->getConnection())
                    ->table($this->upsertTable())
                    ->upsert($records, $this->upsertUniqueBy(), $this->upsertUpdate());
            });
    }

    protected function getConnection()
    {
        return Config::get('snomed-ct-for-laravel.db.temp.connection');
    }
}
