<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('assessment_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained('assessments')->cascadeOnDelete();
            $table->foreignId('aspect_id')->constrained('assessment_aspects')->restrictOnDelete();
            $table->unsignedTinyInteger('score')->default(0);
            $table->timestamps();

            $table->unique(['assessment_id', 'aspect_id']);
        });

        // Pindahkan data nilai yang ada dari tabel assessments ke assessment_scores
        $aspectMap = DB::table('assessment_aspects')->pluck('id', 'key')->toArray();

        $oldAssessments = DB::table('assessments')->get();
        $scoresToInsert = [];

        foreach ($oldAssessments as $assessment) {
            foreach ($aspectMap as $key => $aspectId) {
                if (isset($assessment->{$key})) {
                    $scoresToInsert[] = [
                        'assessment_id' => $assessment->id,
                        'aspect_id' => $aspectId,
                        'score' => (int) $assessment->{$key},
                        'created_at' => $assessment->created_at ?? now(),
                        'updated_at' => $assessment->updated_at ?? now(),
                    ];
                }
            }
        }

        if (! empty($scoresToInsert)) {
            DB::table('assessment_scores')->insert($scoresToInsert);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_scores');
    }
};
