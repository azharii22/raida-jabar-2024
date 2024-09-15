<?php

namespace App\Http\Controllers;

use App\Jobs\GeneratePdfJob;
use App\Models\Kategori;
use App\Models\Peserta;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class CardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function generateIdCards()
    {
        $kategoriPeserta = Kategori::where('name', 'Peserta')->first();

        if (auth()->user()->role_id == 1 || auth()->user()->role_id == 4) {
            $roleId = auth()->user()->role_id;
            GeneratePdfJob::dispatch($roleId);
            return response()->json(['message' => 'PDF generation in progress'], 202);
        } elseif (auth()->user()->role_id == 2) {
            $peserta = Peserta::where('villages_id', auth()->user()->villages_id)
                ->where('kategori_id', $kategoriPeserta->id)
                ->orderBy('nama_lengkap')
                ->get();
            $villages = Peserta::where('villages_id', auth()->user()->villages_id)
                ->where('kategori_id', $kategoriPeserta->id)
                ->orderBy('nama_lengkap')
                ->first();
            $pdf = Pdf::loadView('test-card', compact('peserta'))->setPaper([0, 0, 566.93, 850.394], 'landscape');
            return $pdf->stream('ID Card ' . 'Peserta ' . config('settings.main.1_app_name') . ' ' . $villages->villages->name . '.pdf');
        } elseif (auth()->user()->role_id == 3) {
            $peserta = Peserta::with('villages')
                ->where('regency_id', auth()->user()->regency_id)
                ->where('kategori_id', $kategoriPeserta->id)
                ->orderBy('villages_id')
                // ->limit(10)
                ->get();
            $regency = Peserta::with('villages')
                ->where('regency_id', auth()->user()->regency_id)
                ->where('kategori_id', $kategoriPeserta->id)
                ->first();
            foreach ($peserta as $item) {
                // Path gambar
                $path = public_path('storage/img/peserta/foto/' . $item->foto);

                // Cek apakah file gambar ada
                if (file_exists($path)) {
                    try {
                        // Proses gambar dengan Intervention Image
                        $image = Image::make($path);

                        // Simpan ulang gambar untuk membersihkan data yang rusak
                        $image->save($path);

                        // Coba membaca ukuran gambar dengan getimagesize()
                        $size = getimagesize($path);
                        Log::info('Ukuran gambar: ' . json_encode($size));
                    } catch (\Exception $e) {
                        Log::error('Gagal memproses gambar: ' . $e->getMessage());
                        // Anda bisa memilih untuk melanjutkan tanpa gambar ini atau memberikan placeholder
                    }
                } else {
                    Log::warning('Gambar tidak ditemukan: ' . $path);
                }
            }
            $pdf = Pdf::loadView('test-card', compact('peserta'))->setPaper([0, 0, 566.93, 850.394], 'landscape');
            return $pdf->stream('ID Card ' . 'Peserta ' . config('settings.main.1_app_name') . ' ' . $regency->regency->name . '.pdf');
        }
    }

    public function generateIdCardsRegency($regency_id)
    {
        $peserta = Peserta::where('villages_id', '!=', NULL)
            ->where('regency_id', $regency_id)
            ->orderBy('nama_lengkap')
            ->get();
        foreach ($peserta as $item) {
            $path = public_path('storage/img/peserta/foto/' . $item->foto);
            if (file_exists($path)) {
                try {
                    $image = Image::make($path);
                    $image->save($path);
                    $size = getimagesize($path);
                    Log::info('Ukuran gambar: ' . json_encode($size));
                } catch (\Exception $e) {
                    Log::error('Gagal memproses gambar: ' . $e->getMessage());
                }
            } else {
                Log::warning('Gambar tidak ditemukan: ' . $path);
            }
        }
        $pdf = Pdf::loadView('test-card', compact('peserta'))->setPaper([0, 0, 566.93, 850.394], 'landscape');
        return $pdf->stream('ID Card ' . 'Peserta ' . config('settings.main.1_app_name') . '.pdf');
    }

    public function IdCardsKota($villages_id)
    {
        $peserta = Peserta::where('villages_id', $villages_id)
            ->orderBy('nama_lengkap')
            ->get();
        $pdf = Pdf::loadView('test-card', compact('peserta'))->setPaper([0, 0, 566.93, 850.394], 'landscape');
        return $pdf->stream('ID Card ' . 'Peserta ' . config('settings.main.1_app_name') . '.pdf');
    }

    public function generateIdCardsUnsurKontingen()
    {
        $kategoriNotPeserta = Kategori::whereNotIn('name', ['Peserta'])->pluck('id');

        if (auth()->user()->role_id == 2) {
            $peserta = Peserta::where('user_id', auth()->user()->id)
            ->whereIn('kategori_id', $kategoriNotPeserta)
            ->orderBy('updated_at', 'DESC')
            ->get();

            $villages = Peserta::where('user_id', auth()->user()->id)
                ->whereIn('kategori_id', $kategoriNotPeserta)
                ->first();

            if ($villages) {
                $pdf = Pdf::loadView('test-card', compact('peserta'))
                    ->setPaper([0, 0, 566.93, 850.394], 'landscape');
                return $pdf->stream('ID Card ' . 'Unsur Kontingen ' . config('settings.main.1_app_name') . ' ' . $villages->villages?->name . '.pdf');
            } else {
                return response('Data villages tidak ditemukan', 404);
            }
        } elseif (auth()->user()->role_id == 3) {
            $peserta = Peserta::where('regency_id', auth()->user()->regency_id)
                ->whereIn('kategori_id', $kategoriNotPeserta)
                ->orderBy('regency_id')
                ->get();

            $regency = Peserta::with('regency') // Pastikan relasi dengan 'regency' sudah diatur
                ->where('regency_id', auth()->user()->regency_id)
                ->whereIn('kategori_id', $kategoriNotPeserta)
                ->first();

            foreach ($peserta as $item) {
                $path = public_path('storage/img/peserta/foto/' . $item->foto);
                if (file_exists($path)) {
                    try {
                        $image = Image::make($path);
                        $image->save($path);
                        $size = getimagesize($path);
                        Log::info('Ukuran gambar: ' . json_encode($size));
                    } catch (\Exception $e) {
                        Log::error('Gagal memproses gambar: ' . $e->getMessage());
                    }
                } else {
                    Log::warning('Gambar tidak ditemukan: ' . $path);
                }
            }

            if ($regency) {
                $pdf = Pdf::loadView('test-card', compact('peserta'))
                    ->setPaper([0, 0, 566.93, 850.394], 'landscape');
                return $pdf->stream('ID Card ' . 'Unsur Kontingen ' . config('settings.main.1_app_name') . ' ' . $regency->regency->name . '.pdf');
            } else {
                // Tangani kasus jika $regency tidak ditemukan
                return response('Data regency tidak ditemukan', 404);
            }
        }
    }


    public function generateIdCardsRegencyUnsurKontingen($regency_id)
    {
        $kategoriNotPeserta = Kategori::whereNotIn('name', ['Peserta'])->pluck('id');

        $peserta = Peserta::where('villages_id', NULL)
        ->where('regency_id', $regency_id)
        ->whereIn('kategori_id', $kategoriNotPeserta)
        ->get();
        foreach ($peserta as $item) {
            $path = public_path('storage/img/peserta/foto/' . $item->foto);
            if (file_exists($path)) {
                try {
                    $image = Image::make($path);
                    $image->save($path);
                    $size = getimagesize($path);
                    Log::info('Ukuran gambar: ' . json_encode($size));
                } catch (\Exception $e) {
                    Log::error('Gagal memproses gambar: ' . $e->getMessage());
                }
            } else {
                Log::warning('Gambar tidak ditemukan: ' . $path);
            }
        }
        $pdf = Pdf::loadView('test-card', compact('peserta'))->setPaper([0, 0, 566.93, 850.394], 'landscape');
        return $pdf->stream('ID Card ' . 'Unsur Kontingen ' . config('settings.main.1_app_name') . '.pdf');
    }

}
