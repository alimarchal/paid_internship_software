<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('users', 'exam_config')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            // {"total": 100, "categories": {"<category_id>": <count>, ...}}
            $table->json('exam_config')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('exam_config');
        });
    }
};
