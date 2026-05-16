<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SqlDumpSeeder extends Seeder
{
    /**
     * Import the SQL dump file into the database.
     *
     * @return void
     */
    public function run()
    {
        $sqlFile = database_path('i9135899_lara2.sql');

        if (! file_exists($sqlFile)) {
            $this->command->error("SQL file not found: {$sqlFile}");
            return;
        }

        $this->command->info('Importing SQL dump: i9135899_lara2.sql (' . round(filesize($sqlFile) / 1024) . ' KB)');

        // Disable foreign key checks during import
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $sql = file_get_contents($sqlFile);

        // Split on statement boundaries (semicolons followed by newline)
        // Filter to only INSERT statements — tables already exist from migrations
            // Convert INSERT to INSERT IGNORE to skip duplicates
            $statements = array_filter(
                preg_split('/;\s*\n/', $sql),
                function ($statement) {
                    $trimmed = trim($statement);
                    if (empty($trimmed)) return false;
                    // Remove comments to find the actual SQL keyword
                    $withoutComments = preg_replace('/--.*$/m', '', $trimmed);
                    $withoutComments = preg_replace('/\/\*.*?\*\//s', '', $withoutComments);
                    $withoutComments = trim($withoutComments);
                    // Only keep INSERT statements
                    return stripos($withoutComments, 'INSERT') === 0;
                }
            );

            // Convert INSERT INTO to INSERT IGNORE INTO so existing rows are not overwritten
            $statements = array_map(function ($statement) {
                return preg_replace('/^INSERT\s+INTO/i', 'INSERT IGNORE INTO', trim($statement));
            }, $statements);
        $total = count($statements);
        $executed = 0;
        $errors = 0;

        $bar = $this->command->getOutput()->createProgressBar($total);
        $bar->start();

        foreach ($statements as $statement) {
            $statement = trim($statement);
            if (empty($statement)) {
                $bar->advance();
                continue;
            }

            try {
                DB::unprepared($statement . ';');
                $executed++;
            } catch (\Throwable $e) {
                $errors++;
                // Log but don't stop — some statements may be config/charset settings
                Log::warning("SqlDumpSeeder skipped statement: " . $e->getMessage());
            }

            $bar->advance();
        }

        $bar->finish();
        $this->command->newLine();

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info("Done! Executed: {$executed} | Skipped/Errors: {$errors}");
    }
}
