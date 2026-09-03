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
        Schema::create('counseling_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('counselor_id');
            $table->foreign('counselor_id')->references('userID')->on('users')->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('duration_minutes')->default(60);
            $table->decimal('price', 8, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counseling_services');
    }
};
