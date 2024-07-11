<?php

namespace App\Exports;

use App\Models\Pembayaran;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PembayaranExport implements FromCollection, WithHeadings, WithColumnWidths, WithDrawings, ShouldAutoSize, WithEvents, WithStyles
{
    public function collection()
    {
        $pembayaran = Pembayaran::with('user','status')->orderBy('user_id', 'ASC')->get();
        foreach ($pembayaran as $data) {
            $datas[] = array(
                'nama' => $data->user->name,
                'jumlah_terdaftar' => $data->jumlah_terdaftar . ' Orang',
                'nominal' => $data->nominal,
                'status' => $data->status->name,
                'tanggal_upload' => $data->tanggal_upload,
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

    public function drawings()
    {

        $pembayaran = Pembayaran::with('user')->orderBy('user_id', 'ASC')->get();
        $drawings = [];
        foreach ($pembayaran as $key => $data) {
            $drawing = new Drawing();
            $drawing->setName('Bukti Pembayaran');
            $drawing->setDescription('Bukti Pembayaran');
            $drawing->setPath(public_path(Storage::url('public/pembayaran/') . $data->file));
            $drawing->setHeight(100);
            $drawing->setWidth(100);
            $drawing->setOffsetX(5);
            $drawing->setOffsetY(5);
            $key += 2;
            $drawing->setCoordinates('F' . $key);
            $drawings[] = ($drawing);
            $key++;
        }

        return $drawings;
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // $event->sheet->getDelegate()->getRowDimension('1')->setRowHeight(16);
                $event->sheet->getDefaultRowDimension()->setRowHeight(100);
                $workSheet = $event->sheet->getDelegate();
                $this->collection($workSheet);
                $this->drawings($workSheet);
            },
        ];
    }
    public function headings(): array
    {
        return [
            'Nama',
            'Jumlah Terdaftar',
            'Nominal',
            'Status',
            'Tanggal Upload',
            'Bukti Pembayaran',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 40,
            'B' => 30,
            'C' => 20,
            'D' => 20,
            'E' => 20,
            'F' => 40,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true, 'size' => 12, 'align' => 'center']],

        ];
    }
}
