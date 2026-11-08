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
        // 1. Ubah status inactive menjadi completed pada data yang sudah ada
        DB::table('students')->where('status', 'inactive')->update(['status' => 'completed']);

        // 2. Drop unique index lama pada nis
        Schema::table('students', function (Blueprint $table) {
            $table->dropUnique(['nis']);
        });

        // 3. Rename nis ke identity_number dan tambah kolom-kolom baru
        Schema::table('students', function (Blueprint $table) {
            $table->renameColumn('nis', 'identity_number');
        });

        Schema::table('students', function (Blueprint $table) {
            $table->string('type', 20)->default('prakerin')->after('id'); // prakerin (SMK) / magang (Universitas)
            $table->string('institution')->nullable()->after('major'); // Asal Sekolah / Kampus
            $table->string('faculty')->nullable()->after('institution'); // Fakultas (opsional mahasiswa)
            $table->foreignId('department_id')->nullable()->after('faculty')->constrained('departments')->nullOnDelete();
            $table->string('photo_path')->nullable()->after('department_id');

            // Unique constraint kombinasi tipe dan nomor identitas (NIS / NIM)
            $table->unique(['type', 'identity_number']);

            // Index pencarian dan filter performa tinggi
            $table->index('type');
            $table->index('status');
            $table->index('end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
            $table->dropUnique(['type', 'identity_number']);
            $table->dropIndex(['type']);
            $table->dropIndex(['status']);
            $table->dropIndex(['end_date']);
            $table->dropColumn(['type', 'institution', 'faculty', 'department_id', 'photo_path']);
        });

        Schema::table('students', function (Blueprint $table) {
            $table->renameColumn('identity_number', 'nis');
            $table->unique('nis');
        });
    }
};
