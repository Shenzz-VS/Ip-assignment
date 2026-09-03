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
        Schema::create('assessment_results', function (Blueprint $table) {
            $table->id();
            
            // 1. Create the column first
            $table->unsignedBigInteger('user_id');
            // 2. Explicitly define the foreign key relationship
            $table->foreign('user_id')->references('userID')->on('users')->cascadeOnDelete();
            
            // 3. Link to the assessment
            $table->unsignedBigInteger('assessment_id');
            $table->foreign('assessment_id')->references('id')->on('assessments')->cascadeOnDelete();
            
            // 4. Store the score
            $table->integer('score')->default(0);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_results');
    }
};
