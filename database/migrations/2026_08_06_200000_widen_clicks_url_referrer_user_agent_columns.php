<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Widen url, referrer, and user_agent columns using raw SQL
     * to avoid requiring doctrine/dbal.
     */
    public function up()
    {
        // Drop the existing index on url (can't have index on TEXT without length)
        DB::statement('ALTER TABLE `clicks` DROP INDEX `clicks_url_index`');

        DB::statement('ALTER TABLE `clicks` MODIFY `url` TEXT NULL');
        DB::statement('ALTER TABLE `clicks` MODIFY `referrer` TEXT NULL');
        DB::statement('ALTER TABLE `clicks` MODIFY `user_agent` TEXT NULL');

        // Re-add url index with a prefix length (first 191 chars)
        DB::statement('ALTER TABLE `clicks` ADD INDEX `clicks_url_index` (`url`(191))');
    }

    public function down()
    {
        DB::statement('ALTER TABLE `clicks` DROP INDEX `clicks_url_index`');

        DB::statement('ALTER TABLE `clicks` MODIFY `url` VARCHAR(255) NULL');
        DB::statement('ALTER TABLE `clicks` MODIFY `referrer` VARCHAR(255) NULL');
        DB::statement('ALTER TABLE `clicks` MODIFY `user_agent` VARCHAR(255) NULL');

        DB::statement('ALTER TABLE `clicks` ADD INDEX `clicks_url_index` (`url`)');
    }
};
