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

    // public function generateIdCards()
    // {
    //     $notKontingen = Kategori::where('name', 'LIKE', 'Peserta')->first();
    //     $date = Carbon::now()->format('d-m-Y');
    //     if (auth()->user()->role_id == 2) {
    //         $peserta = Peserta::where('villages_id', auth()->user()->villages_id)
    //             ->where('kategori_id', $notKontingen->id)
    //             ->orderBy('nama_lengkap')
    //             ->get();
    //     } elseif (auth()->user()->role_id == 3) {
    //         $peserta = Peserta::with('villages')
    //             ->where('regency_id', auth()->user()->regency_id)
    //             ->where('kategori_id', $notKontingen->id)
    //             ->orderBy('villages_id')
    //             ->first();
    //     }
    //     foreach ($peserta as $pesertaItem) {
    //         $imagePath = public_path('images/' . $pesertaItem->foto);
    //         $img = Image::make($imagePath)->resize(300, 300);
    //         $img->save(public_path('images/converted_' . $pesertaItem->foto));
    //     }
    //     return view('test-card', compact('peserta'));
    // }

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
            $data = Peserta::with('villages')
                ->where('regency_id', auth()->user()->regency_id)
                ->where('kategori_id', $kategoriPeserta->id)
                ->orderBy('villages_id')
                ->first();
        }
        return view('test-card', compact('data'));
        // $pdf = Pdf::loadView('test-card', compact('data'))->setPaper('a3', 'potrait');
        // return $pdf->stream('Peserta ' . config('settings.main.1_app_name') . ' ' . $date . '.pdf');

        $html = view('test-card', compact('data'))->render();

        $image = SnappyImage::loadHTML($html)
            ->setOption('format', 'jpeg')
            ->setOption('quality', 90)
            ->setOption('width', 1200)
            ->setOption('height', 2400);

        $outputFile = storage_path('app/public/id-card/' . $data->id . '-' . $data->nama_lengkap . '.jpg');
        $image->save($outputFile);

        return response()->download($outputFile);
    }
}
