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
        Schema::create('gym', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // Member Information
            $table->string('name');

            // Membership Details
            $table->date('start_date');
            $table->date('end_date')->nullable(); // Allow null values for ongoing memberships
            $table->enum('membership_type', ['basic', 'premium', 'custom']); // Define membership types

            // Contact Information
            $table->string('mobile_number');
            $table->string('email')->unique(); // Ensure unique email addresses

            // Additional fields (consider adding)
            $table->string('emergency_contact_name')->nullable(); // Optional emergency contact
            $table->string('emergency_contact_number')->nullable(); // Optional emergency contact number
            $table->text('notes')->nullable(); // Optional notes for specific memberships
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gym');
    }
};
