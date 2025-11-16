<?php

namespace App\Exports;

use App\Models\Registrasi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class RegistrasiAnakExport implements 
    FromCollection, 
    WithHeadings, 
    ShouldAutoSize, 
    WithStyles,
    WithEvents
{
    public function collection()
    {
        return Registrasi::with(['anak', 'sekolah', 'jenisSekolah'])
            ->get()
            ->map(function ($item) {
                $a = $item->anak;

                return [
                    $item->id,
                    $item->sekolah->nama_sekolah ?? '-',
                    $item->jenisSekolah->nama_jenis ?? '-',
                    $item->status,
                    $item->nominal_transfer,
                    $item->waktu_daftar,
                    $item->deadline_bayar,
                    $item->kode_transaksi,

                    $a->nama_lengkap ?? '-',
                    $a->tempat_lahir ?? '-',
                    $a->tanggal_lahir ?? '-',
                    $a->asal_sekolah ?? '-',
                    $a->rerata_rapor ?? '-',
                    $a->prestasi ?? '-',
                    $a->jenis_kelamin ?? '-',
                    $a->agama ?? '-',
                    $a->kewarganegaraan ?? '-',
                    $a->nik ?? '-',
                    $a->no_kk ?? '-',
                    $a->no_akta_lahir ?? '-',
                    $a->tempat_tinggal ?? '-',
                    $a->moda_transportasi ?? '-',
                    $a->jarak_rumah ?? '-',
                    $a->anak_ke ?? '-',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID Registrasi',
            'Sekolah Tujuan',
            'Jenis Sekolah',
            'Status',
            'Nominal Transfer',
            'Waktu Daftar',
            'Deadline Pembayaran',
            'Kode Transaksi',

            'Nama Anak',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Asal Sekolah',
            'Rerata Rapor',
            'Prestasi',
            'Jenis Kelamin',
            'Agama',
            'Kewarganegaraan',
            'NIK',
            'No KK',
            'No Akta Lahir',
            'Tempat Tinggal',
            'Moda Transportasi',
            'Jarak Rumah',
            'Anak Ke',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'color'    => ['rgb' => 'E5E7EB'], // abu-abu terang
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            \Maatwebsite\Excel\Events\AfterSheet::class => function ($event) {
                $sheet = $event->sheet->getDelegate();

                // Tentukan range kolom
                $lastColumn = $sheet->getHighestColumn();
                $lastRow = $sheet->getHighestRow();

                // Border full table
                $sheet->getStyle("A1:{$lastColumn}{$lastRow}")
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                // Auto wrap text
                $sheet->getStyle("A1:{$lastColumn}{$lastRow}")
                    ->getAlignment()
                    ->setWrapText(true);

                // Alignment default: kiri
                $sheet->getStyle("A2:{$lastColumn}{$lastRow}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_LEFT);
            },
        ];
    }
}
