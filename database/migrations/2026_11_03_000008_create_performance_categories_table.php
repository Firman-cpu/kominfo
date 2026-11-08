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
        Schema::create('performance_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('level_key', 50)->unique();
            $table->decimal('min_score', 5, 2)->default(0);
            $table->text('description')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // Seed Kategori Performa Default
        $categories = [
            [
                'name' => 'Sangat Baik',
                'level_key' => 'excellent',
                'min_score' => 90.00,
                'description' => 'Performa siswa/mahasiswa sangat baik dan memuaskan.',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Baik',
                'level_key' => 'good',
                'min_score' => 80.00,
                'description' => 'Performa siswa/mahasiswa baik dan konsisten.',
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cukup',
                'level_key' => 'average',
                'min_score' => 70.00,
                'description' => 'Performa siswa/mahasiswa cukup dan masih dapat ditingkatkan.',
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Perlu Perhatian',
                'level_key' => 'attention',
                'min_score' => 60.00,
                'description' => 'Performa siswa/mahasiswa membutuhkan perhatian.',
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Perlu Evaluasi',
                'level_key' => 'evaluation',
                'min_score' => 0.00,
                'description' => 'Performa siswa/mahasiswa membutuhkan evaluasi lebih lanjut.',
                'sort_order' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('performance_categories')->insert($categories);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_categories');
    }
};
