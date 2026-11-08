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
        Schema::create('assessment_aspects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('key', 100)->unique();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Seed 6 Aspek Nilai Awal
        $aspects = [
            ['name' => 'Kedisiplinan', 'key' => 'discipline', 'sort_order' => 1, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tanggung Jawab', 'key' => 'responsibility', 'sort_order' => 2, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kerja Sama', 'key' => 'teamwork', 'sort_order' => 3, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Komunikasi', 'key' => 'communication', 'sort_order' => 4, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Inisiatif', 'key' => 'initiative', 'sort_order' => 5, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kualitas Kerja', 'key' => 'work_quality', 'sort_order' => 6, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('assessment_aspects')->insert($aspects);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_aspects');
    }
};
