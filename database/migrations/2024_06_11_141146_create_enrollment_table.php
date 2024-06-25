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
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // User Information
            $table->string('first_name');
            $table->string('middle_name')->nullable(); // Allow null values for middle name
            $table->string('last_name');
            $table->date('date_of_birth');
            $table->string('place_of_birth');
            $table->enum('gender', ['male', 'female']); // Define enum for gender

            // Contact Information
            $table->string('address');
            $table->string('mobile_number');
            $table->string('email')->unique(); // Ensure unique email addresses

            // Section information (assuming it's still needed)
            $table->string('section'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollment');
    }
};
