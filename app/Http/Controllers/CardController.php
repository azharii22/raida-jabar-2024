<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Peserta;
use Barryvdh\DomPDF\Facade\Pdf;

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
            $peserta = Peserta::where('villages_id', '!=', NULL)
                ->orderBy('nama_lengkap')
                ->get();
            $pdf = Pdf::loadView('test-card', compact('peserta'))->setPaper('a3', 'landscape');
            return $pdf->stream('ID Card ' . 'Peserta ' . config('settings.main.1_app_name') . '.pdf');
        } elseif (auth()->user()->role_id == 2) {
            $peserta = Peserta::where('villages_id', auth()->user()->villages_id)
                ->where('kategori_id', $kategoriPeserta->id)
                ->orderBy('nama_lengkap')
                ->get();
            $villages = Peserta::where('villages_id', auth()->user()->villages_id)
                ->where('kategori_id', $kategoriPeserta->id)
                ->orderBy('nama_lengkap')
                ->get();
            $pdf = Pdf::loadView('test-card', compact('peserta'))->setPaper('a3', 'landscape');
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
            $pdf = Pdf::loadView('test-card', compact('peserta'))->setPaper('a3', 'landscape');
            return $pdf->stream('ID Card ' . 'Peserta ' . config('settings.main.1_app_name') . ' ' . $regency->regency->name . '.pdf');
        }
    }
}
