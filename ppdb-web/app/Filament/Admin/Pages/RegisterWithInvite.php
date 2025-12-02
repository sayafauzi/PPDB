<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Forms\Components;
use App\Models\Akun;
use App\Models\InviteCode;
use App\Models\AkunSekolah;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Hash;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Facades\DB;

class RegisterWithInvite extends Page
{
    protected static ?string $title = 'Pendaftaran Admin Sekolah';
    protected static ?string $slug = 'register-with-invite';
    protected static bool $shouldRegisterNavigation = false;
    protected static bool $navigation = false;

    // gunakan layout filament bawaan (tanpa sidebar)
    protected string $view = 'filament.admin.pages.register-with-invite';

    public ?array $data = [];

    public static function shouldRegisterNavigation(): bool
    {
        return false; // agar tidak muncul di sidebar login
    }


    // halaman ini bisa diakses publik
    public static function canAccess(): bool
    {
        return true;
    }

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                        Section::make('Daftar Akun Admin Sekolah')
                            ->description('Gunakan kode undangan yang telah diberikan oleh SuperAdmin untuk mendaftar sebagai admin sekolah.')
                            ->schema([
                        TextInput::make('invite_code')
                            ->label('Kode Undangan')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('email')
                            ->label('Email (Username)')
                            ->email()
                            ->required(),

                        TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required(),

                        TextInput::make('no_telp')
                            ->label('Nomor Telepon')
                            ->tel()
                            ->nullable(),

                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->required()
                            ->minLength(8)
                            ->confirmed(),

                        TextInput::make('password_confirmation')
                            ->label('Konfirmasi Password')
                            ->password()
                            ->required(),

                        Action::make('register')
                            ->label('Daftar')
                            ->button()
                            ->submit('register')
                            ->color('primary')
                            ->icon('heroicon-o-user-plus'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function register(): void
    {
        $data = $this->form->getState();

        DB::transaction(function () use ($data) {
            $invite = InviteCode::where('code', $data['invite_code'])
                ->where('is_used', false)
                ->where('target_tipe', 'A')
                ->first();

            if (!$invite) {
                Notification::make()
                    ->danger()
                    ->title('Kode Undangan Tidak Valid')
                    ->body('Silakan periksa kembali kode undangan Anda atau hubungi SuperAdmin.')
                    ->send();
                return;
            }

            $akun = Akun::create([
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'name' => $data['name'],
                'no_telp' => $data['no_telp'] ?? null,
                'tipe_akun' => 'A',
            ]);

            // Jika ada sekolah yang dikaitkan dengan invite
            if (isset($invite->sekolah_id)) {
                AkunSekolah::create([
                    'akun_id' => $akun->id,
                    'sekolah_id' => $invite->sekolah_id,
                    'role_in_school' => 'admin',
                ]);
            }

            $invite->update(['is_used' => true]);

            Notification::make()
                ->success()
                ->title('Pendaftaran Berhasil')
                ->body('Akun Anda berhasil dibuat! Silakan login ke panel admin.')
                ->send();

            $this->redirectRoute('filament.admin.auth.login');
        });
    }
}
