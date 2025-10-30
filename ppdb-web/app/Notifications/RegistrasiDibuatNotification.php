<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Filament\Notifications\Notification as FilamentNotification;

class RegistrasiDibuatNotification extends Notification implements ShouldQueue
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
            ->subject('Pendaftaran Diterima')
            ->greeting('Halo, ' . $notifiable->name)
            ->line('Pendaftaran anak Anda telah berhasil dibuat.')
            ->line('Kode Registrasi: ' . $this->registrasi->id)
            ->action('Lihat Detail', url('/parent/registrasi/' . $this->registrasi->id))
            ->line('Terima kasih telah mendaftar di sistem PPDB!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Registrasi berhasil',
            'body' => 'Pendaftaran anak telah berhasil dibuat. Kode: ' . $this->registrasi->id,
            'url' => '/parent/registrasi/' . $this->registrasi->id,
        ];
    }

    public function toFilament($notifiable)
    {
        FilamentNotification::make()
            ->title('Pendaftaran berhasil')
            ->body('Kode registrasi: ' . $this->registrasi->id)
            ->success()
            ->sendToDatabase($notifiable);
    }
}
