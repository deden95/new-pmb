<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MahasiswaExport implements FromCollection, WithTitle, WithHeadings, WithMapping, WithStyles, WithColumnWidths, ShouldAutoSize
{
    public function collection()
    {
        return User::orderBy('created_at', 'desc')->get();
    }

    public function title(): string
    {
        return 'Data Mahasiswa';
    }

    public function headings(): array
    {
        return [
            'NO',
            'NAMA LENGKAP',
            'ALAMAT EMAIL',
            'NOMOR HP (WA)',
            'STATUS',
            'TGL DAFTAR'
        ];
    }

    public function map($user): array
    {
        static $rowNumber = 0;
        $rowNumber++;
        
        return [
            $rowNumber, // Nomor urut
            $user->name,
            $user->email,
            $user->phone ? "'" . preg_replace('/^0/', '62', $user->phone) : '-',
            $user->status ? 'AKTIF' : 'NON-AKTIF',
            $user->created_at->format('d/m/Y H:i')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style untuk header
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['rgb' => '4b5563'],
                ],
                'alignment' => [
                    'horizontal' => 'center',
                    'vertical' => 'center',
                ],
            ],
            
            // Style untuk data
            'A2:F1000' => [
                'alignment' => [
                    'vertical' => 'center',
                ],
            ],
            
            // Style khusus untuk kolom nomor
            'A' => [
                'alignment' => [
                    'horizontal' => 'center',
                ],
            ],
            
            // Format text untuk kolom nomor HP
            'D' => [
                'numberFormat' => [
                    'formatCode' => '@'
                ],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,   // NO
            'B' => 30,  // NAMA LENGKAP
            'C' => 25,  // ALAMAT EMAIL
            'D' => 20,  // NOMOR HP (WA)
            'E' => 15,  // STATUS
            'F' => 20,  // TGL DAFTAR
        ];
    }
}