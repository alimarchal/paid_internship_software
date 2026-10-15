<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('batches')) {
            Schema::create('batches', function (Blueprint $table) {
                $table->id();
                $table->string('name', 50)->unique();
                // New registrations are assigned to the batch flagged here (exactly one).
                $table->boolean('is_registration')->default(false);
                $table->timestamps();
            });
        }

        foreach (['Batch-01', 'Batch-02', 'Batch-03'] as $name) {
            DB::table('batches')->insertOrIgnore(['name' => $name, 'created_at' => now(), 'updated_at' => now()]);
        }
        if (! DB::table('batches')->where('is_registration', true)->exists()) {
            DB::table('batches')->where('name', 'Batch-03')->update(['is_registration' => true]);
        }

        if (! Schema::hasTable('settings')) {
            Schema::create('settings', function (Blueprint $table) {
                $table->string('key')->primary();
                $table->text('value')->nullable();
                $table->timestamps();
            });
        }
        DB::table('settings')->insertOrIgnore([
            'key' => 'registration_deadline',
            'value' => '2026-10-16 23:59:59',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // users.batch_no was an enum; batches are now managed in Settings, so any batch name must fit.
        if (in_array(DB::getDriverName(), ['mysql', 'mariadb'])) {
            DB::statement("ALTER TABLE users MODIFY batch_no VARCHAR(50) NOT NULL DEFAULT 'Batch-01'");
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
        Schema::dropIfExists('batches');
    }
};
