<?php

namespace App\Console\Commands;

use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SyncStudentStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'students:sync-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sinkronisasi status otomatis siswa & mahasiswa (ubah ke completed jika end_date telah lewat)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $today = Carbon::today();

        $updated = Student::where('status', 'active')
            ->whereNotNull('end_date')
            ->whereDate('end_date', '<', $today)
            ->update([
                'status' => 'completed',
                'updated_at' => now(),
            ]);

        $this->info("Berhasil sinkronisasi status: {$updated} peserta diperbarui menjadi Selesai (completed).");

        return Command::SUCCESS;
    }
}
