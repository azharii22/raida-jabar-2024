<?php

namespace App\Helpers;

use Clegginabox\PDFMerger\PDFMerger;

class PdfMerger
{
    public static function merge($files, $outputPath)
    {
        $pdf = new PDFMerger;

        foreach ($files as $file) {
            $pdf->addPDF($file, 'all');
        }

        $pdf->merge('file', $outputPath);
    }
}
