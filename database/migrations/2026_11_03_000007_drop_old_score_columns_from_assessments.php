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
        Schema::table('assessments', function (Blueprint $table) {
            $table->dropColumn([
                'discipline',
                'responsibility',
                'teamwork',
                'communication',
                'initiative',
                'work_quality',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assessments', function (Blueprint $table) {
            $table->unsignedTinyInteger('discipline')->default(0)->after('assessment_date');
            $table->unsignedTinyInteger('responsibility')->default(0)->after('discipline');
            $table->unsignedTinyInteger('teamwork')->default(0)->after('responsibility');
            $table->unsignedTinyInteger('communication')->default(0)->after('teamwork');
            $table->unsignedTinyInteger('initiative')->default(0)->after('communication');
            $table->unsignedTinyInteger('work_quality')->default(0)->after('initiative');
        });
    }
};
