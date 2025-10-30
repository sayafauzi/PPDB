<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Filament\Notifications\Notification as FilamentNotification;

class StatusRegistrasiUpdatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $registrasi;

    public function __construct($registrasi)
    {
        $this->registrasi = $registrasi;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Status Pendaftaran Diperbarui')
            ->greeting('Halo, ' . $notifiable->name)
            ->line('Status pendaftaran anak Anda telah diperbarui menjadi: **' . ucfirst($this->registrasi->status) . '**.')
            ->action('Lihat Detail', url('/parent/registrasi/' . $this->registrasi->id))
            ->line('Harap periksa dashboard Anda untuk informasi lebih lanjut.');
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Status Registrasi Diperbarui',
            'body' => 'Status pendaftaran anak telah berubah menjadi ' . ucfirst($this->registrasi->status),
            'url' => '/parent/registrasi/' . $this->registrasi->id,
        ];
    }

    public function toFilament($notifiable)
    {
        FilamentNotification::make()
            ->title('Status Pendaftaran Diperbarui')
            ->body('Status: ' . ucfirst($this->registrasi->status))
            ->info()
            ->sendToDatabase($notifiable);
    }
}
