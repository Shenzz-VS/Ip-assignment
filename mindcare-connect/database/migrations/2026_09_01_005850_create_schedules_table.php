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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('counselor_id'); // Links to the users table
            $table->date('available_date');
            $table->time('start_window');
            $table->time('end_window');
            $table->boolean('is_booked')->default(false); // Changes to true when a patient books it
            $table->timestamps();

            // Enforce relational integrity
            $table->foreign('counselor_id')->references('userID')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
