<?php

namespace App\Jobs;

use App\Models\Kategori;
use App\Models\Peserta;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;

class ExportLargePdf implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    public function handle()
    {
        Log::info('Job Started');
        $progressFile = storage_path('app/pdf-progress.json');
        Log::info('Progress File: ' . $progressFile);

        try {
            if (File::exists($progressFile)) {
                file_put_contents($progressFile, json_encode([
                    'progress' => 0,
                    'downloadUrl' => null
                ]));
            }
            $kategoriNotPeserta = Kategori::whereNotIn('name', ['Peserta'])->pluck('id');
            $tempPdfPath = storage_path('app/public/' . $this->filePath);
            Log::info('File Path: ' . $tempPdfPath);

            // Create directory if it doesn't exist
            $directory = dirname($tempPdfPath);
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            // Delete the PDF if it already exists
            if (Storage::exists('public/' . $this->filePath)) {
                Storage::delete('public/' . $this->filePath);
            }

            $totalEntries = Peserta::where('villages_id', null)
                ->whereIn('kategori_id', $kategoriNotPeserta)
                ->count();
            $chunksProcessed = 0;
            $chunkSize = 1000; // Define chunkSize here

            $allHtml = '';
            $tempPdfFiles = [];
            $currentRowNumber = 1;  // Initialize row number

            Peserta::where('villages_id', null)
                ->whereIn('kategori_id', $kategoriNotPeserta)
                ->orderBy('updated_at', 'DESC')
                ->chunk($chunkSize, function ($entries) use (&$allHtml, $totalEntries, &$chunksProcessed, $progressFile, &$tempPdfFiles, &$currentRowNumber, $chunkSize) {
                    Log::info('Processing chunk of ' . count($entries) . ' entries');
                    $chunksProcessed += count($entries);
                    $progress = intval(($chunksProcessed / $totalEntries) * 100);

                    if ($progress < 100) {
                        file_put_contents($progressFile, json_encode([
                            'progress' => $progress,
                            'downloadUrl' => null
                        ]));
                    }

                    $isFirstChunk = ($chunksProcessed <= $chunkSize);

                    $html = view('unsurKontingen.pdf', [
                        'entries' => $entries,
                        'currentRowNumber' => $currentRowNumber,
                        'isFirstChunk' => $isFirstChunk
                    ])->render();

                    $currentRowNumber += count($entries);

                    $pdf = Pdf::loadHTML($html)->setPaper('a3', 'landscape');
                    $tempFilePath = storage_path('app/public/temp_chunk_' . $chunksProcessed . '.pdf');
                    $pdf->save($tempFilePath);
                    Log::info('Saved temporary PDF: ' . $tempFilePath);
                    $tempPdfFiles[] = $tempFilePath;
                });

            Log::info('Finished processing all chunks at ' . now());

            Log::info('Generating final PDF');
            $finalPdfPath = storage_path('app/public/' . $this->filePath);
            $pdf = new Fpdi();
            foreach ($tempPdfFiles as $tempFilePath) {
                $pageCount = $pdf->setSourceFile($tempFilePath);
                for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                    $tplIdx = $pdf->ImportPage($pageNo);
                    $pdf->AddPage('L', 'A3');
                    $pdf->UseTemplate($tplIdx);
                }
                File::delete($tempFilePath);
                Log::info('Deleted temporary PDF: ' . $tempFilePath);
            }
            $pdf->Output('F', $finalPdfPath);

            file_put_contents($progressFile, json_encode([
                'progress' => 100,
                'downloadUrl' => url('storage/' . $this->filePath)
            ]));
            Log::info('Final PDF saved to ' . $finalPdfPath);
            Log::info('Job done');
        } catch (\Exception $e) {
            Log::error('Job failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
