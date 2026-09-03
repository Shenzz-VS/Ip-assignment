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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('counselor_id');
            $table->unsignedBigInteger('schedule_id');
            $table->date('appointment_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('status')->default('Pending'); // Can be: Pending, Approved, Rejected, Completed
            $table->text('notes')->nullable(); // For the patient to say what they want to discuss
            $table->timestamps();

            // Strict foreign key constraints
            $table->foreign('patient_id')->references('userID')->on('users')->onDelete('cascade');
            $table->foreign('counselor_id')->references('userID')->on('users')->onDelete('cascade');
            $table->foreign('schedule_id')->references('id')->on('schedules')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
