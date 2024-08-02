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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('avatar')->nullable();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('employee_id')->unique()->nullable();
            $table->foreignId('department_id')->nullable()->constrained('departments')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('designation_id')->nullable()->constrained('designations')->onUpdate('cascade');
            $table->enum('servicetype', ['Probation', 'Permanent'])->default('Probation');
            $table->integer('salary')->nullable();
            $table->string('job_location')->nullable();
            $table->date('joined_at')->nullable();
            $table->date('permanent_at')->nullable();

            // Information
            $table->date('date_of_birth')->nullable();
            $table->date('marital_status')->nullable();
            $table->enum('gender',      ['Male', 'Female', 'Other'])->nullable();
            $table->enum('title',       ['Mr.', 'Ms.', 'Mrs.'])->nullable();
            $table->string('blood_group')->nullable();
            $table->string('contact')->nullable();

            // Identification
            $table->string('nid')->nullable();
            $table->string('passport')->nullable();
            $table->string('driving_license')->nullable();

            // Ethinic Information
            $table->string('religion')->nullable();
            $table->string('nationality')->nullable();

            // Family details
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('spouse_name')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
