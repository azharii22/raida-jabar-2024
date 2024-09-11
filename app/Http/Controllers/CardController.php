<?php

namespace App\Http\Controllers;

use App\Jobs\GeneratePdfForChunkJob;
use App\Models\Kategori;
use App\Models\Peserta;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\Snappy\Facades\SnappyImage;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Bus;
use Intervention\Image\ImageManagerStatic as Image;
use ZipArchive;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\FacadesLog;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;
use Imagick;
use Spatie\PdfToImage\Pdf as PdfToImagePdf;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessUtils;
use ZipStream\ZipStream;

class CardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function generateIdCards()
    {
        $kategoriPeserta = Kategori::where('name', 'Peserta')->first();
        $date = Carbon::now()->format('d-m-Y');

        if (auth()->user()->role_id == 2) {
            $peserta = Peserta::where('villages_id', auth()->user()->villages_id)
                ->where('kategori_id', $kategoriPeserta->id)
                ->orderBy('nama_lengkap')
                ->get();
            Log::info('Peserta yang diambil untuk villages_id:', ['villages_id' => auth()->user()->villages_id, 'jumlah_peserta' => $peserta->count()]);
        } elseif (auth()->user()->role_id == 3) {
            $peserta = Peserta::with('villages')
                ->where('regency_id', auth()->user()->regency_id)
                ->where('kategori_id', $kategoriPeserta->id)
                ->orderBy('villages_id')
                ->limit(10)
                ->get();
        }
        $pdf = Pdf::loadView('test-card', compact('peserta'))->setPaper('a3', 'landscape');
        return $pdf->stream('Peserta ' . config('settings.main.1_app_name') . ' ' . $date . '.pdf');
    }



}
