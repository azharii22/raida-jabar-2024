<?php

namespace App\Exports;

use App\Models\Kategori;
use App\Models\Peserta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PesertaExport implements
    FromCollection,
    WithHeadings,
    WithStyles
{
    public function collection()
    {
        $kategori = Kategori::where('name', 'LIKE', 'Peserta')->first();
        if (auth()->user()->role_id == 1 || auth()->user()->role_id == 4) {
            $peserta = Peserta::get();
        } elseif (auth()->user()->role_id == 2) {
            $peserta = Peserta::where(
                'villages_id',
                auth()->user()->villages_id
            )->orderBy('nama_lengkap')->where('kategori_id', $kategori->id)->get();
        } elseif (auth()->user()->role_id == 3) {
            $peserta = Peserta::with('villages')->where(
                'regency_id',
                auth()->user()->regency_id
            )->orderBy('villages_id')->where('kategori_id', $kategori->id)->get();
        }
        foreach ($peserta as $data) {

            $datas[] = array(
                'regency_id'            => $data->regency->name,
                'villages_id'           => $data->villages?->name ? $data->villages?->name : $data->regency->name,
                'kategori'              => $data->kategori?->name,
                'nama_lengkap'          => $data->nama_lengkap,
                'tempat_lahir'          => $data->tempat_lahir,
                'tanggal_lahir'         => date('d-F-Y', strtotime($data->tempat_lahir)),
                'jenis_kelamin'         => $data->jenis_kelamin == 1 ? "Laki-laki" : "Perempuan", // 1 = laki-laki, 2 = perempuan
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
            'Wilayah Cabang', //A
            'Wilayah Ranting', //B
            'Kategori', //C
            'Nama Lengkap', //D
            'Tempat Lahir', //E
            'Tanggal Lahir', //F
            'Jenis Kelamin', //G
            'Ukuran Kaos', //H
            'No HP', //I
            'Agama', //J
            'Golongan Darah', //K
            'Riwayat Penyakit', //L
            'Status', //M
            'Catatan', //N
            'Foto', //O
            'KTA', //P
            'Asuransi Kesehatan', //Q
            'Sertif SFH', //R
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:R1')->getFont()->setBold(true);
        $sheet->getStyle('A1:R1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(40);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(20);
        $sheet->getColumnDimension('J')->setWidth(20);
        $sheet->getColumnDimension('K')->setWidth(25);
        $sheet->getColumnDimension('L')->setWidth(30);
        $sheet->getColumnDimension('M')->setWidth(25);
        $sheet->getColumnDimension('N')->setWidth(30);
        $sheet->getColumnDimension('O')->setWidth(30);
        $sheet->getColumnDimension('P')->setWidth(30);
        $sheet->getColumnDimension('Q')->setWidth(30);
        $sheet->getColumnDimension('R')->setWidth(30);

        $peserta = $this->collection();
        $rowIndex = 2;
        foreach ($peserta as $data) {
            $maxHeight = 100; // Default height
            // Gambar pertama
            if (!is_null($data['foto'])) {
                $path1 = public_path(Storage::url('public/img/peserta/foto/') . $data['foto']);
                if (file_exists($path1)) {
                    $drawing1 = new Drawing();
                    $drawing1->setPath($path1); // Menggunakan path absolut
                    $drawing1->setCoordinates('O' . $rowIndex);
                    $drawing1->setName('Foto');
                    $drawing1->setDescription('Foto');
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
                Log::warning('File path is null for photo Nama Lengkap: ' . $data['nama_lengkap']);
            }

            // Gambar kedua
            if (!is_null($data['KTA'])) {
                $path2 = public_path(Storage::url('public/img/peserta/kta/') . $data['KTA']);
                if (file_exists($path2)) {
                    $drawing2 = new Drawing();
                    $drawing2->setPath($path2); // Menggunakan path absolut
                    $drawing2->setCoordinates('P' . $rowIndex);
                    $drawing2->setName('KTA');
                    $drawing2->setDescription('KTA');
                    $drawing2->setHeight(100);
                    $drawing2->setWidth(100);
                    $drawing2->setOffsetX(5);
                    $drawing2->setOffsetY(5);
                    $drawing2->setWorksheet($sheet);
                    $maxHeight = max($maxHeight, $drawing2->getHeight()); // Menyimpan tinggi gambar tertinggi
                } else {
                    Log::warning('File not found: ' . $path2);
                }
            } else {
                Log::warning('File path is null for photo Nama Lengkap: ' . $data['nama_lengkap']);
            }

            // Gambar ketiga
            if (!is_null($data['asuransi_kesehatan'])) {
                $path3 = public_path(Storage::url('public/img/peserta/asuransi-kesehatan/') .
                $data['asuransi_kesehatan']);
                if (file_exists($path3)) {
                    $drawing3 = new Drawing();
                    $drawing3->setPath($path3); // Menggunakan path absolut
                    $drawing3->setCoordinates('P' . $rowIndex);
                    $drawing3->setName('Asuransi Kesehatan');
                    $drawing3->setDescription('Asuransi Kesehatan');
                    $drawing3->setHeight(100);
                    $drawing3->setWidth(100);
                    $drawing3->setOffsetX(5);
                    $drawing3->setOffsetY(5);
                    $drawing3->setWorksheet($sheet);
                    $maxHeight = max($maxHeight, $drawing3->getHeight()); // Menyimpan tinggi gambar tertinggi
                } else {
                    Log::warning('File not found: ' . $path3);
                }
            } else {
                Log::warning('File path is null for photo Nama Lengkap: ' . $data['nama_lengkap']);
            }

            // Gambar kedua
            if (!is_null($data['sertif_sfh'])) {
                $path4 = public_path(Storage::url('public/img/peserta/sertif-sfh/') . $data['sertif_sfh']);
                if (file_exists($path4)) {
                    $drawing4 = new Drawing();
                    $drawing4->setPath($path4); // Menggunakan path absolut
                    $drawing4->setCoordinates('P' . $rowIndex);
                    $drawing4->setName('Sertif Sfh');
                    $drawing4->setDescription('Sertif Sfh');
                    $drawing4->setHeight(100);
                    $drawing4->setWidth(100);
                    $drawing4->setOffsetX(5);
                    $drawing4->setOffsetY(5);
                    $drawing4->setWorksheet($sheet);
                    $maxHeight = max($maxHeight, $drawing4->getHeight()); // Menyimpan tinggi gambar tertinggi
                } else {
                    Log::warning('File not found: ' . $path4);
                }
            } else {
                Log::warning('File path is null for photo Nama Lengkap: ' . $data['nama_lengkap']);
            }

            $sheet->getRowDimension((int)$rowIndex)->setRowHeight($maxHeight);
            $rowIndex++;
        }
        // Menghapus path gambar dari sel
        for ($i = 2; $i <= $peserta->count() + 1; $i++) {
            $sheet->setCellValue('O' . $i, '');
            $sheet->setCellValue('P' . $i, '');
            $sheet->setCellValue('Q' . $i, '');
            $sheet->setCellValue('R' . $i, '');
        }
        $currentName = '';
        $startRow = 2;
        for ($i = 2; $i <= $peserta->count() + 1; $i++) {
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
        if ($startRow < $peserta->count() + 1) {
            $sheet->mergeCells('A' . $startRow . ':A' . ($peserta->count() + 1));
        }
        // Mengatur teks di kolom A agar berada di tengah (centered)
        $sheet->getStyle('A2:A' . ($peserta->count() + 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2:A' . ($peserta->count() + 1))->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
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
}
