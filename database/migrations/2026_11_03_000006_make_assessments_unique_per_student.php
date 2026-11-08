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
        // 1. Bersihkan duplikat penilaian siswa historis bila ada
        $duplicateStudentIds = DB::table('assessments')
            ->select('student_id')
            ->groupBy('student_id')
            ->havingRaw('COUNT(id) > 1')
            ->pluck('student_id');

        foreach ($duplicateStudentIds as $studentId) {
            // Ambil id penilaian terbaru
            $latestAssessmentId = DB::table('assessments')
                ->where('student_id', $studentId)
                ->orderByDesc('id')
                ->value('id');

            // Hapus penilaian yang lebih lama
            $oldAssessmentIds = DB::table('assessments')
                ->where('student_id', $studentId)
                ->where('id', '!=', $latestAssessmentId)
                ->pluck('id');

            if ($oldAssessmentIds->isNotEmpty()) {
                DB::table('assessment_scores')->whereIn('assessment_id', $oldAssessmentIds)->delete();
                DB::table('assessments')->whereIn('id', $oldAssessmentIds)->delete();
            }
        }

        // 2. Pasang unique constraint 1-to-1 pada student_id
        Schema::table('assessments', function (Blueprint $table) {
            $table->unique('student_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assessments', function (Blueprint $table) {
            $table->dropUnique(['student_id']);
        });
    }
};
