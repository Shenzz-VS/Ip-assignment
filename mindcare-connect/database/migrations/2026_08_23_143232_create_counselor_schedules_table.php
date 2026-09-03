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
        Schema::create('counselor_schedules', function (Blueprint $table) {
                $table->id();
                // Links to the counselor
                $table->foreignId('counselor_id')->constrained('users', 'userID')->cascadeOnDelete();
                
                // The actual schedule details
                $table->string('day_of_week'); // e.g., Monday, Tuesday
                $table->time('start_time');
                $table->time('end_time');
                
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counselor_schedules');
    }
};
