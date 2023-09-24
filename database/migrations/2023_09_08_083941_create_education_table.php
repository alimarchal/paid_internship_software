<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('education', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('education_level')->nullable();
            $table->string('board_university_name')->nullable();
            $table->integer('passing_year')->nullable();
            $table->string('cgpa_cpa_grade')->nullable();
            $table->string('division')->nullable();
            $table->string('percentage_marks')->nullable();
            $table->string('major_subject')->nullable();
            $table->string('degree_photo_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('education');
    }
};
