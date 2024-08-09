<?php

namespace App\Exports;

use App\Models\Peserta;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Intervention\Image\Facades\Image;

class PesertaRegencyExport implements FromCollection, WithHeadings, WithStyles
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function collection()
    {
        $peserta = Peserta::where('regency_id', $this->id)
            ->where('villages_id', '!=', null)
            ->orderBy('nama_lengkap')
            ->get();

        $datas = $peserta->map(function ($data) {
            return [
                'regency_id'            => $data->regency?->name,
                'villages_id'           => $data->villages?->name ?: $data->regency?->name,
                'kategori'              => $data->kategori?->name,
                'nama_lengkap'          => $data->nama_lengkap,
                'tempat_lahir'          => $data->tempat_lahir,
                'tanggal_lahir'         => $data->tanggal_lahir ? date('d-F-Y', strtotime($data->tanggal_lahir)) : '-',
                'jenis_kelamin'         => $data->jenis_kelamin === 1 ? "Laki-laki" : ($data->jenis_kelamin === 2 ? "Perempuan" : "Tidak diketahui"),
                'ukuran_kaos'           => $data->ukuran_kaos,
                'no_hp'                 => $data->no_hp,
                'agama'                 => $data->agama,
                'golongan_darah'        => $data->golongan_darah,
                'riwayat_penyakit'      => $data->riwayat_penyakit,
                'status'                => $data->status?->name,
                'catatan'               => $data->catatan,
                'foto'                  => $data->foto,
                'KTA'                   => $data->KTA,
                'asuransi_kesehatan'    => $data->asuransi_kesehatan,
                'sertif_sfh'            => $data->sertif_sfh,
            ];
        });

        return $datas->isNotEmpty() ? $datas : collect();
    }

    public function cleanAndSaveImage($path, $outputPath)
    {
        try {
            // Periksa apakah file ada sebelum memproses
            if (!file_exists($path)) {
                Log::error('File not found: ' . $path);
                return false;
            }

            // Coba membuat instance gambar
            $image = Image::make($path);

            // Simpan gambar ke output path
            $image->save($outputPath);

            return $outputPath;
        } catch (\Exception $e) {
            // Tangkap dan log error jika terjadi
            Log::error('Error processing image: ' . $e->getMessage());
            return false;
        }
    }

    public function headings(): array
    {
        return [
            'Wilayah Cabang',
            'Wilayah Ranting',
            'Kategori',
            'Nama Lengkap',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Ukuran Kaos',
            'No HP',
            'Agama',
            'Golongan Darah',
            'Riwayat Penyakit',
            'Status',
            'Catatan',
            'Foto',
            'KTA',
            'Asuransi Kesehatan',
            'Sertif SFH',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:R1')->getFont()->setBold(true);
        $sheet->getStyle('A1:R1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $columns = range('A', 'R');
        foreach ($columns as $column) {
            $sheet->getColumnDimension($column)->setWidth(30);
        }

        $peserta = $this->collection();
        $rowIndex = 2;

        foreach ($peserta as $data) {
            $maxHeight = 100;

            $this->insertImage($sheet, $data['foto'], 'O' . $rowIndex, $maxHeight);
            $this->insertImage($sheet, $data['KTA'], 'P' . $rowIndex, $maxHeight);
            $this->insertImage($sheet, $data['asuransi_kesehatan'], 'Q' . $rowIndex, $maxHeight);
            $this->insertImage($sheet, $data['sertif_sfh'], 'R' . $rowIndex, $maxHeight);

            $sheet->getRowDimension($rowIndex)->setRowHeight($maxHeight);
            $rowIndex++;
        }

        // Menghapus path gambar dari sel
        for ($i = 2; $i <= $peserta->count() + 1; $i++) {
            $sheet->setCellValue('O' . $i, '');
            $sheet->setCellValue('P' . $i, '');
            $sheet->setCellValue('Q' . $i, '');
            $sheet->setCellValue('R' . $i, '');
        }

        $this->mergeCellsAndCenterText($sheet, $peserta, 'A');

        return [
            'A1:R' . ($peserta->count() + 1) => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ],
        ];
    }

    protected function insertImage(Worksheet $sheet, $imagePath, $cell, &$maxHeight)
    {
        if (!is_null($imagePath)) {
            // Misalkan Anda menyimpan informasi folder di dalam model atau konfigurasi
            $folderPath = $this->determineFolderPath($imagePath);

            // Buat path lengkap untuk gambar
            $path = public_path($folderPath . $imagePath);

            // Log untuk memverifikasi path gambar
            Log::info('Generated image path: ' . $path);

            // Bersihkan dan simpan gambar
            $cleanPath = $this->cleanAndSaveImage($path, public_path('cleaned_' . basename($path)));

            // Periksa apakah file gambar benar-benar ada
            if (file_exists($cleanPath)) {
                $drawing = new Drawing();
                $drawing->setPath($cleanPath);
                $drawing->setCoordinates($cell);
                $drawing->setName('Image');
                $drawing->setDescription('Image');
                $drawing->setHeight(100);
                $drawing->setWidth(100);
                $drawing->setOffsetX(5);
                $drawing->setOffsetY(5);
                $drawing->setWorksheet($sheet);
                $maxHeight = max($maxHeight, $drawing->getHeight());
            } else {
                Log::warning('File not found: ' . $path);
            }
        } else {
            Log::warning('File path is null for image: ' . $cell);
        }
    }

    protected function determineFolderPath($imagePath)
    {
        // Logika untuk menentukan folder berdasarkan nama file atau informasi lain
        // Misalnya, Anda bisa menggunakan ekstensi file atau nama file untuk menentukan folder
        if (strpos($imagePath, 'foto') !== false) {
            return 'storage/img/peserta/foto/';
        } elseif (strpos($imagePath, 'kta') !== false) {
            return 'storage/img/peserta/kta/';
        } elseif (strpos($imagePath, 'asuransi-kesehatan') !== false) {
            return 'storage/img/peserta/asuransi-kesehatan/';
        } elseif (strpos($imagePath, 'sertif-sfh') !== false) {
            return 'storage/img/peserta/sertif-sfh/';
        }

        // Default folder jika tidak ada kecocokan
        return 'storage/img/peserta/default/';
    }

    protected function mergeCellsAndCenterText(Worksheet $sheet, $peserta, $column)
    {
        $currentName = '';
        $startRow = 2;
        for ($i = 2; $i <= $peserta->count() + 1; $i++) {
            $albumName = $sheet->getCell($column . $i)->getValue();
            if ($albumName !== $currentName) {
                if ($startRow < $i - 1) {
                    $sheet->mergeCells($column . $startRow . ':' . $column . ($i - 1));
                }
                $currentName = $albumName;
                $startRow = $i;
            }
        }

        if ($startRow < $peserta->count() + 1) {
            $sheet->mergeCells($column . $startRow . ':' . $column . ($peserta->count() + 1));
        }

        $sheet->getStyle($column . '2:' . $column . ($peserta->count() + 1))
            ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);
    }
}
