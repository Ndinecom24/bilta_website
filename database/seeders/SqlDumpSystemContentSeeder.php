<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SqlDumpSystemContentSeeder extends Seeder
{
    private const DUMP_FILE = 'i9135899_lara2.sql';

    private const IMPORT_TABLES = [
        'cookie_consents',
        'testimonies',
        'permissions',
        'roles',
        'roles_permissions',
        'gallery_item',
        'media',
        'contact_messages',
    ];

    public function run()
    {
        $dumpPath = database_path(self::DUMP_FILE);

        if (!is_file($dumpPath)) {
            return;
        }

        $insertStatementsByTable = $this->extractInsertStatementsByTable($dumpPath);

        if (empty($insertStatementsByTable)) {
            return;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        try {
            foreach (self::IMPORT_TABLES as $table) {
                if (!isset($insertStatementsByTable[$table]) || !Schema::hasTable($table)) {
                    continue;
                }

                try {
                    DB::table($table)->delete();

                    foreach ($insertStatementsByTable[$table] as $statement) {
                        DB::unprepared($statement);
                    }
                } catch (QueryException $exception) {
                    continue;
                }
            }
        } finally {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }
    }

    private function extractInsertStatementsByTable(string $dumpPath): array
    {
        $handle = fopen($dumpPath, 'r');

        if ($handle === false) {
            return [];
        }

        $statementsByTable = [];
        $buffer = '';

        while (($line = fgets($handle)) !== false) {
            $trimmed = trim($line);

            if ($trimmed === '' || str_starts_with($trimmed, '--')) {
                continue;
            }

            $buffer .= $line;

            if (!str_ends_with(rtrim($trimmed), ';')) {
                continue;
            }

            $statement = trim($buffer);
            $buffer = '';

            if (!preg_match('/^INSERT\s+INTO\s+`([^`]+)`/i', $statement, $matches)) {
                continue;
            }

            $table = $matches[1];

            if (!in_array($table, self::IMPORT_TABLES, true)) {
                continue;
            }

            $statementsByTable[$table][] = $statement;
        }

        fclose($handle);

        return $statementsByTable;
    }
}
