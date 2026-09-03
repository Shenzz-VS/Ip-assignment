<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('assessment_results', function (Blueprint $table) {
            $table->text('counselor_feedback')->nullable()->after('score');
        });
    }

    public function down()
    {
        Schema::table('assessment_results', function (Blueprint $table) {
            $table->dropColumn('counselor_feedback');
        });
    }
};
