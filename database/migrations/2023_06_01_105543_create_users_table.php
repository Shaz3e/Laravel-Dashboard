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
            // Login information
            $table->string('username')->unique()->nullable();
            $table->string('email')->unique();
            $table->string('password');
            // Personal information
            $table->string('first_name');
            $table->string('last_name');
            $table->dateTime('dob')->nullable();
            $table->string('mobile')->unique()->nullable();
            // Location information
            $table->integer('country')->nullable();
            $table->integer('state')->nullable();
            $table->integer('city')->nullable();
            $table->integer('zip_code')->nullable();
            // Additional Contact Information
            $table->string('company')->nullable();
            $table->string('house_number')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            // verification
            $table->boolean('is_verified')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
