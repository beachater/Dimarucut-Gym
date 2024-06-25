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
        Schema::create('gyms', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // Member Information
            $table->string('name');

            // Membership Details
            $table->date('start_date');
            $table->date('end_date')->nullable(); // Allow null values for ongoing memberships
            $table->enum('membership_type', ['basic', 'premium', 'custom']); // Define membership types
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
