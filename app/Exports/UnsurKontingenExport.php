<?php

namespace App\Exports;

use App\Models\Kategori;
use App\Models\Peserta;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;



class UnsurKontingenExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function  view(): View
    {
        $kategoriNotPeserta = Kategori::whereNotIn('name', ['Peserta'])->pluck('id');
        if (Auth::user()->role_id == 1) {
            return view('unsurKontingen.excel', [
                'peserta' => Peserta::with('user')->whereIn('kategori_id', $kategoriNotPeserta)->get()
            ]);
        } elseif (Auth::user()->role_id == 2) {
            return view('unsurKontingen.excel', [
                'peserta' => Peserta::where('villages_id', Auth::user()->villages_id)->whereIn('kategori_id', $kategoriNotPeserta)->orderBy('nama_lengkap')->get()
            ]);
        } elseif (Auth::user()->role_id == 3) {
            return view('unsurKontingen.excel', [
                'peserta' => Peserta::with('villages')->where('regency_id', Auth::user()->regency_id)->orderBy('villages_id')->whereIn('kategori_id', $kategoriNotPeserta)->get()
            ]);
        }
    }
}
