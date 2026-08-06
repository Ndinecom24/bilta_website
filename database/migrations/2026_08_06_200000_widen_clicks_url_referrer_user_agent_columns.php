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
        DB::statement('ALTER TABLE `clicks` MODIFY `url` TEXT NULL');
        DB::statement('ALTER TABLE `clicks` MODIFY `referrer` TEXT NULL');
        DB::statement('ALTER TABLE `clicks` MODIFY `user_agent` TEXT NULL');
    }

    public function down()
    {
        DB::statement('ALTER TABLE `clicks` MODIFY `url` VARCHAR(255) NULL');
        DB::statement('ALTER TABLE `clicks` MODIFY `referrer` VARCHAR(255) NULL');
        DB::statement('ALTER TABLE `clicks` MODIFY `user_agent` VARCHAR(255) NULL');
    }
};
