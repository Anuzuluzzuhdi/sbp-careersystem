<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

abstract class CsvSeeder extends Seeder
{
    protected function importCsv(string $filePath, string $table, array $columnMap = []): void
    {
        $rows = $this->parseCsv($filePath);
        if (empty($rows)) {
            return;
        }

        // Map CSV columns to DB columns for every row first
        $mapped = [];
        foreach ($rows as $row) {
            if ($columnMap === []) {
                $mapped[] = $row;
            } else {
                $insert = [];
                foreach ($columnMap as $csvKey => $columnName) {
                    $insert[$columnName] = $row[$csvKey] ?? null;
                }
                $mapped[] = $insert;
            }
        }

        // Bulk insert in chunks of 500 rows per query instead of one query
        // per row. Reduces ~5800 individual INSERT round-trips to ~12.
        foreach (array_chunk($mapped, 500) as $chunk) {
            DB::table($table)->insert($chunk);
        }
    }

    protected function parseCsv(string $relativePath): array
    {
        $path = base_path($relativePath);
        if (!file_exists($path)) {
            return [];
        }

        $rows = [];
        if (($handle = fopen($path, 'r')) !== false) {
            $headers = fgetcsv($handle);
            if ($headers === false) {
                fclose($handle);
                return [];
            }

            $headers = array_map(fn ($header) => trim($header), $headers);
            while (($data = fgetcsv($handle)) !== false) {
                if (count($data) !== count($headers)) {
                    continue;
                }

                $rows[] = array_combine($headers, $data);
            }
            fclose($handle);
        }

        return $rows;
    }
}
