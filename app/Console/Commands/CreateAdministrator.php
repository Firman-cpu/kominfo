<?php

namespace App\Console\Commands;

use App\Models\Admin;
use App\Services\ActivityLogger;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateAdministrator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create-administrator';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Membuat akun Administrator cadangan (maksimal tepat 2 akun administrator)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $adminCount = Admin::where('role', 'administrator')->count();

        if ($adminCount >= 2) {
            $this->error('Gagal: Sistem hanya mengizinkan maksimal tepat 2 akun Administrator (1 Akun Utama dan 1 Akun Cadangan).');

            return Command::FAILURE;
        }

        $this->info("Saat ini terdapat {$adminCount} akun Administrator. Membuat akun Administrator cadangan...");

        $name = $this->ask('Masukkan Nama Lengkap Administrator:');
        $username = $this->ask('Masukkan Username:');

        $validator = Validator::make([
            'name' => $name,
            'username' => $username,
        ], [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'alpha_dash', 'min:3', 'unique:admins,username'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return Command::FAILURE;
        }

        $password = $this->secret('Masukkan Password (min 8 karakter):');
        $passwordConfirmation = $this->secret('Konfirmasi Password:');

        if ($password !== $passwordConfirmation) {
            $this->error('Konfirmasi password tidak cocok.');

            return Command::FAILURE;
        }

        if (strlen($password) < 8) {
            $this->error('Password minimal 8 karakter.');

            return Command::FAILURE;
        }

        $admin = Admin::create([
            'name' => $name,
            'username' => $username,
            'password' => Hash::make($password),
            'role' => 'administrator',
            'is_primary' => false,
            'is_active' => true,
        ]);

        ActivityLogger::log('create', "Akun Administrator cadangan '{$admin->username}' dibuat via Artisan CLI", 'Admin', $admin->id);

        $this->info("Akun Administrator cadangan '{$admin->username}' berhasil dibuat!");

        return Command::SUCCESS;
    }
}
