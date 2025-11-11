<?php

namespace App\Filament\Resources\Registrasi\Schemas;

use App\Models\Anak;
use App\Models\JenisSekolah;
use App\Models\Sekolah;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class RegistrasiForm
{
    public static function configure(Schema $schema): Schema
    {
        $user = Auth::user();

        return $schema
            ->components([
                Section::make('Data Pendaftaran')
                ->description('Lengkapi data pendaftaran anak dan sekolah tujuan.')
                ->columns(2)
                ->schema([

                    Select::make('id_anak')
                        ->label('Anak')
                        ->relationship('anak', 'nama_lengkap')
                        ->searchable()
                        ->required()
                        ->preload()
                        ->options(function () use ($user) {
                            // Orang tua hanya bisa melihat anak miliknya
                            if ($user->tipe_akun === 'U') {
                                return Anak::where('id_akun_orangtua', $user->id)
                                    ->pluck('nama_lengkap', 'id');
                            }
                            // Admin / SU bisa melihat semua anak
                            return Anak::pluck('nama_lengkap', 'id');
                        }),

                    // Select::make('id_sekolah')
                    //     ->label('Sekolah Tujuan')
                    //     ->relationship('sekolah', 'nama_sekolah')
                    //     ->searchable()
                    //     ->required()
                    //     ->preload()
                    //     ->options(function () use ($user) {
                    //         if ($user->tipe_akun === 'A') {
                    //             // Admin hanya sekolah yang diassign padanya
                    //             return Sekolah::whereHas('akunSekolah', function ($q) use ($user) {
                    //                 $q->where('akun_id', $user->id);
                    //             })
                    //                 ->where('status_aktif', true)
                    //                 ->pluck('nama_sekolah', 'id');
                    //         }
                    //         return Sekolah::where('status_aktif', true)
                    //             ->pluck('nama_sekolah', 'id');
                    //     }),

                    Select::make('id_sekolah')
                        ->label('Sekolah Tujuan')
                        ->options(function () use ($user) {
                            if ($user->tipe_akun === 'A') {
                                return Sekolah::whereHas('akunSekolah', fn($q) => 
                                    $q->where('akun_id', $user->id)
                                )
                                ->where('status_aktif', true)
                                ->pluck('nama_sekolah', 'id');
                            }
                            return Sekolah::where('status_aktif', true)
                                ->pluck('nama_sekolah', 'id');
                        })
                        ->searchable()
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set) {
                            $sekolah = Sekolah::find($state);
                            $set('nominal_transfer', $sekolah?->biaya_pendaftaran ?? 0);
                            $set('jenis_sekolah_id', null); // reset pilihan jenis saat ganti sekolah
                        }),

                    Select::make('jenis_sekolah_id')
                        ->label('Jenis Sekolah')
                        // ->options(function (callable $get) {
                        //     $sekolahId = $get('id_sekolah');
                        //     if (!$sekolahId) return [];
                        //     return \App\Models\JenisSekolah::where('sekolah_id', $sekolahId)
                        //         ->where('status_aktif', true)
                        //         ->get()
                        //         ->mapWithKeys(fn($jenis) => [
                        //             $jenis->id => "{$jenis->nama_jenis} (Kuota: {$jenis->sisa_kuota}/{$jenis->kuota})"
                        //         ]);
                        // })
                        ->relationship('jenisSekolah', 'nama_jenis', function ($query, callable $get) {
                            return $query->when($get('id_sekolah'), fn ($q) =>
                                $q->where('sekolah_id', $get('id_sekolah'))
                            );
                        })
                        ->options(function (callable $get) {
                            $idSekolah = $get('id_sekolah');
                            if (!$idSekolah) return [];

                            // ambil semua jenis sekolah yang tersedia pada sekolah ini
                            return JenisSekolah::where('sekolah_id', $idSekolah)
                                ->get()
                                ->mapWithKeys(function ($jenis) {
                                    $label = "{$jenis->nama_jenis} (Kuota: {$jenis->sisa_kuota}/{$jenis->kapasitas})";
                                    return [$jenis->id => $label];
                                });
                        })
                        ->getOptionLabelUsing(function ($value) {
                            $jenis = JenisSekolah::find($value);
                            return $jenis ? "{$jenis->nama_jenis} (Kuota: {$jenis->sisa_kuota}/{$jenis->kapasitas})" : null;
                        })
                        ->required()
                        ->searchable()
                        ->preload()
                        ->helperText('Pilih jenis sekolah berdasarkan kuota yang tersedia.')
                        ->reactive(),

                    Select::make('status')
                        ->label('Status Pendaftaran')
                        ->options([
                            'menunggu_pembayaran' => 'Menunggu Pembayaran',
                            'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
                            'bukti_bayar_ditolak' => 'Bukti Bayar Ditolak',
                            'pendaftaran_batal' => 'Pendaftaran Batal',
                            'dibayar' => 'Dibayar',
                            'lulus_tes_akademik' => 'Lulus Tes Akademik',
                            'lulus' => 'Lulus',
                            'lulus_bersyarat' => 'Lulus Bersyarat',
                            'cadangan' => 'Cadangan',
                            'belum_diterima' => 'Belum Diterima',
                        ])
                        ->default('menunggu_pembayaran')
                        ->required()
                        ->visible(fn() => in_array($user->tipe_akun, ['SU', 'A'])) // hanya admin / SU
                        ->columnSpanFull(),
                ]),
                
                Section::make('Pembayaran')
                ->description('Isi data pembayaran untuk validasi.')
                ->columns(2)
                ->schema([
                    FileUpload::make('bukti_pembayaran')
                        ->label('Bukti Pembayaran')
                        ->directory('bukti-pembayaran')
                        ->image()
                        ->visibility('public')
                        ->helperText('Upload bukti pembayaran (JPG/PNG).')
                        ->required(fn() => $user->tipe_akun === 'U'),

                    DateTimePicker::make('waktu_daftar')
                        ->label('Waktu Daftar')
                        ->default(now())
                        ->disabled(fn() => $user->tipe_akun === 'U')
                        ->required(),

                    DateTimePicker::make('deadline_bayar')
                        ->label('Deadline Pembayaran')
                        ->default(fn() => now()->addDay())
                        ->disabled(fn() => $user->tipe_akun === 'U')
                        ->helperText('Otomatis diatur 24 jam setelah pendaftaran.'),

                    TextInput::make('nominal_transfer')
                        ->label('Nominal Transfer')
                        ->numeric()
                        ->required()
                        ->prefix('Rp')
                        ->placeholder('Masukkan jumlah pembayaran'),

                    TextInput::make('kode_transaksi')
                        ->label('Kode Transaksi')
                        ->default(fn() => 'TRX' . strtoupper(uniqid()))
                        ->disabled(fn() => $user->tipe_akun === 'U'),
                ]),
            ]);
    }
}
