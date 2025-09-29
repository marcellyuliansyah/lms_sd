<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Ujian;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ExamReminderNotification;

class SendExamReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Ujian $ujian;

    /**
     * Buat job dengan data ujian.
     */
    public function __construct(Ujian $ujian)
    {
        $this->ujian = $ujian;
        $this->onQueue('notifications'); // khusus antrian notifications
    }

    /**
     * Jalankan job.
     */
    public function handle(): void
    {
        // Cari siswa di kelas/mapel ujian
        $siswas = User::where('role', 'siswa')->get();

        foreach ($siswas as $siswa) {
            Notification::send($siswa, new ExamReminderNotification($this->ujian));
        }

        Log::info("Reminder ujian '{$this->ujian->judul}' berhasil dikirim ke semua siswa.");
    }
}
