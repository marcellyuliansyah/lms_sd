<?php

namespace App\Notifications;

use App\Models\Ujian;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExamReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public Ujian $ujian;

    public function __construct(Ujian $ujian)
    {
        $this->ujian = $ujian;
        $this->onQueue('notifications'); // pastikan notifikasi masuk ke queue notifications
    }

    public function via(object $notifiable): array
    {
        return ['mail']; // bisa ditambah database, sms, dll
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Pengingat Ujian: {$this->ujian->judul}")
            ->line("Halo {$notifiable->name},")
            ->line("Ujian {$this->ujian->judul} untuk mata pelajaran {$this->ujian->mapel->nama_mapel} akan dimulai pada:")
            ->line($this->ujian->waktu_mulai->format('d-m-Y H:i'))
            ->action('Buka LMS', url('/dashboard'))
            ->line('Semoga sukses!');
    }
}
