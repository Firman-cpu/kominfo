<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->binary('photo_data')->nullable()->after('is_active');
            $table->string('photo_mime', 50)->nullable()->default(null)->after('photo_data');
        });

        // Upgrade BLOB → MEDIUMBLOB for larger image support (up to 16MB)
        $driver = DB::connection()->getDriverName();
        if ($driver !== 'sqlite') {
            DB::statement('ALTER TABLE admins MODIFY photo_data MEDIUMBLOB NULL');
        }

        Schema::table('students', function (Blueprint $table) {
            $table->binary('photo_data')->nullable()->after('photo_path');
            $table->string('photo_mime', 50)->nullable()->default(null)->after('photo_data');
        });

        if ($driver !== 'sqlite') {
            DB::statement('ALTER TABLE students MODIFY photo_data MEDIUMBLOB NULL');
        }
    }

    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn(['photo_data', 'photo_mime']);
        });

        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['photo_data', 'photo_mime']);
        });
    }
};
