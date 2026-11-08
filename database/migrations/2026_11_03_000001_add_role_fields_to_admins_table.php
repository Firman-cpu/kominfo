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
        Schema::table('admins', function (Blueprint $table) {
            $table->string('name')->default('Administrator')->after('id');
            $table->string('role', 20)->default('operator')->after('password');
            $table->boolean('is_primary')->default(false)->after('role');
            $table->boolean('is_active')->default(true)->after('is_primary');
            $table->timestamp('last_login_at')->nullable()->after('is_active');
        });

        // Set akun Diskominfo default sebagai Administrator Utama (Primary)
        DB::table('admins')
            ->where('id', 1)
            ->orWhere('username', 'Diskominfo')
            ->update([
                'name' => 'Administrator Utama',
                'role' => 'administrator',
                'is_primary' => true,
                'is_active' => true,
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn(['name', 'role', 'is_primary', 'is_active', 'last_login_at']);
        });
    }
};
