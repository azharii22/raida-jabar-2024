<?php

namespace App\Jobs;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ZipArchive;

class GeneratePdfForChunkJob implements ShouldQueue
{
     use Dispatchable, Queueable;

    protected $chunk;
    protected $index;

    public function __construct($chunk, $index)
    {
        $this->chunk = $chunk;
        $this->index = $index;
    }

    public function handle()
    {
        $pdfFiles = [];
        foreach ($this->chunk as $peserta) {
            $pdf = Pdf::loadView('test-card', compact('peserta'));
            $pdfName = 'id_card_' . $peserta->nama_lengkap . '.pdf';
            $pdfPath = storage_path('app/public/id_cards/' . $pdfName);
            $pdf->save($pdfPath);
            $pdfFiles[] = $pdfPath;
        }

        $zipPath = storage_path('app/public/id_cards_chunk_' . $this->index . '.zip');
        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
            foreach ($pdfFiles as $file) {
                $zip->addFile($file, basename($file));
            }
            $zip->close();
        }
    }
}
