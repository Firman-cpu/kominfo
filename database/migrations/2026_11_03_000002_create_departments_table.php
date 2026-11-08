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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('code', 50)->unique();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // Seed 4 Bidang Dinas Kominfo
        $departments = [
            ['name' => 'Sekretariat', 'code' => 'SEKRETARIAT', 'sort_order' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Teknologi Informasi (TI)', 'code' => 'TI', 'sort_order' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Statistik', 'code' => 'STATISTIK', 'sort_order' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Informasi dan Komunikasi Publik (Infokom)', 'code' => 'INFOKOM', 'sort_order' => 4, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('departments')->insert($departments);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
