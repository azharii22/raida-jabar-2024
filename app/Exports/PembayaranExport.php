<?php

namespace App\Exports;

use App\Models\Pembayaran;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PembayaranExport implements
    FromCollection,
    WithHeadings,
    WithStyles
{
    public function collection()
    {
        $pembayaran = Pembayaran::with('user', 'status')->orderBy('user_id')->get();
        foreach ($pembayaran as $data) {
            $datas[] = array(
                'nama'              => $data->user->name,
                'jumlah_terdaftar'  => $data->jumlah_terdaftar . ' Orang',
                'nominal'           => $data->nominal,
                'status'            => $data->status->name,
                'tanggal_upload'    => date('d-F-Y', strtotime($data->tanggal_upload)),
                'file'              => $data->file,
            );
        }
        if (isset($datas)) {
            $data = collect($datas);
        } else {
            $datas = [];
            $data = collect($datas);
        }

        return $data;
    }
    public function headings(): array
    {
        return [
            'Nama', //A
            'Jumlah Terdaftar', //B
            'Nominal (Rp)', //C
            'Status', //D
            'Tanggal Upload', //E
            'Bukti Pembayaran', //F
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:F1')->getFont()->setBold(true);
        $sheet->getStyle('A1:F1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(40);

        $pembayaran = $this->collection();
        $rowIndex = 2;
        foreach ($pembayaran as $data) {
            $maxHeight = 100; // Default height
            // Gambar pertama
            if (!is_null($data['file'])) {
                $path1 = public_path(Storage::url('public/pembayaran/') . $data['file']);
                if (file_exists($path1)) {
                    $drawing1 = new Drawing();
                    $drawing1->setPath($path1); // Menggunakan path absolut
                    $drawing1->setCoordinates('F' . $rowIndex);
                    $drawing1->setName('Bukti Pembayaran');
                    $drawing1->setDescription('Bukti Pembayaran');
                    $drawing1->setHeight(100);
                    $drawing1->setWidth(100);
                    $drawing1->setOffsetX(5);
                    $drawing1->setOffsetY(5);
                    $drawing1->setWorksheet($sheet);
                    $maxHeight = max($maxHeight, $drawing1->getHeight()); // Menyimpan tinggi gambar tertinggi
                } else {
                    Log::warning('File not found: ' . $path1);
                }
            } else {
                Log::warning('File path is null for photo Nama Lengkap: ' . $data['nama']);
            }

            $sheet->getRowDimension((int)$rowIndex)->setRowHeight($maxHeight);
            $rowIndex++;
        }
        // Menghapus path gambar dari sel
        for ($i = 2; $i <= $pembayaran->count() + 1; $i++) {
            $sheet->setCellValue('F' . $i, '');
        }
        // Mengatur format number currency Rupiah untuk kolom harga
        $sheet->getStyle('C2:C' . ($pembayaran->count() + 1))
            ->getNumberFormat()
            ->setFormatCode('"Rp"#,##0.00_-');
        // Menggabungkan kolom berdasarkan foreign key
        $currentName = '';
        $startRow = 2;
        for ($i = 2; $i <= $pembayaran->count() + 1; $i++) {
            $albumName = $sheet->getCell('A' . $i)->getValue();
            if ($albumName !== $currentName) {
                if ($startRow < $i - 1) {
                    $sheet->mergeCells('A' . $startRow . ':A' . ($i - 1));
                }
                $currentName = $albumName;
                $startRow = $i;
            }
        }
        // Menggabungkan kolom terakhir jika ada
        if ($startRow < $pembayaran->count() + 1) {
            $sheet->mergeCells('A' . $startRow . ':A' . ($pembayaran->count() + 1));
        }
        // Mengatur teks di kolom A agar berada di tengah (centered)
        $sheet->getStyle('A2:A' . ($pembayaran->count() + 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2:A' . ($pembayaran->count() + 1))->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        return [
            'A1:F' . ($pembayaran->count() + 1) => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ],
        ];
    }
}
