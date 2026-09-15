<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')
                ->constrained('students')
                ->cascadeOnDelete();

            $table->date('assessment_date');

            $table->unsignedTinyInteger('discipline');
            $table->unsignedTinyInteger('responsibility');
            $table->unsignedTinyInteger('teamwork');
            $table->unsignedTinyInteger('communication');
            $table->unsignedTinyInteger('initiative');
            $table->unsignedTinyInteger('work_quality');

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};