<?php

namespace App\Exports;

use App\Models\Peserta;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class PesertaExport implements FromView
{
    public function view(): View
    {
        if (Auth::user()->role_id == 1) {
            return view('peserta.excel', [
                'peserta' => Peserta::with('user')->get()
            ]);
        } elseif (Auth::user()->role_id == 2) {
            return view('peserta.excel', [
                'peserta' => Peserta::where('villages_id', Auth::user()->villages_id)->orderBy('nama_lengkap')->get()
            ]);
        } elseif (Auth::user()->role_id == 3) {
            return view('peserta.excel', [
                'peserta' => Peserta::with('villages')->where('regency_id', Auth::user()->regency_id)->orderBy('villages_id')->get()
            ]);
        }
    }
}
