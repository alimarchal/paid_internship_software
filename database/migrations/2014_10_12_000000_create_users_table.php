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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('fathers_name')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('nationality')->nullable();
            $table->enum('gender', ['Male', 'Female'])->nullable();
            $table->string('cnic_number')->nullable();
            $table->enum('marital_status', ['Married', 'Single'])->nullable();
            $table->string('district')->nullable();
            $table->string('district_of_domicile')->nullable();
            $table->text('mailing_address')->nullable();
            $table->string('religion')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('degree_level')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->string('cnic_front_path', 2048)->nullable();
            $table->string('cnic_back_path', 2048)->nullable();
            $table->boolean('profile_status')->default(0);
            $table->string('test_center')->nullable();
            $table->string('reporting_time')->nullable();
            $table->date('test_date')->nullable();
            $table->boolean('exam_taken')->default(0);
            $table->boolean('start_test')->default(0);
            $table->timestamp('start_test_time')->nullable();
            $table->timestamp('end_test_time')->nullable();
            $table->enum('status',['Pending','Shortlisted','Rejected'])->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
