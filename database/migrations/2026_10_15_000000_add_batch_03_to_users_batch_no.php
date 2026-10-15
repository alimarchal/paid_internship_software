<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (! in_array(DB::getDriverName(), ['mysql', 'mariadb'])) {
            return;
        }

        DB::statement("ALTER TABLE users MODIFY batch_no ENUM('Batch-01','Batch-02','Batch-03') NOT NULL DEFAULT 'Batch-01'");
    }

    public function down(): void
    {
        if (! in_array(DB::getDriverName(), ['mysql', 'mariadb'])) {
            return;
        }

        DB::statement("ALTER TABLE users MODIFY batch_no ENUM('Batch-01','Batch-02') NOT NULL DEFAULT 'Batch-01'");
    }
};
