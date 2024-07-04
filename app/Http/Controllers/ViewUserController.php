<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\DokumenPenting;
use App\Models\DokumentasiKegiatan;
use App\Models\JadwalKegiatan;
use App\Models\Peserta;
use App\Models\UnsurKontingen;
class ViewUserController extends Controller
{
    public function index()
    {
        $artikel    = Artikel::paginate(10);
        $peserta    = Peserta::all();
        $kontingen  = UnsurKontingen::all();
        return view('viewUser.index', compact(['artikel', 'peserta', 'kontingen']));
    }

    public function tentang()
    {
        return view('viewUser.tentang');
    }

    public function mediaUnduh()
    {
        $media = DokumenPenting::orderBy('updated_at', 'DESC')->get();
        return view('viewUser.media_unduh', compact('media'));
    }

    public function artikel()
    {
        $artikel = Artikel::orderBy('updated_at', 'DESC')->get();
        return view('viewUser.artikel', compact('artikel'));
    }
    public function kegiatan()
    {
        return view('viewUser.kegiatan');
    }
    public function jadwalKegiatan()
    {
        $jadwalKegiatan = JadwalKegiatan::orderBy('updated_at', 'DESC')->get();
        return view('viewUser.jadwal-kegiatan', compact('jadwalKegiatan'));
    }
    public function dokumentasi()
    {
        $dokumentasi = DokumentasiKegiatan::orderBy('updated_at', 'DESC')->get();
        return view('viewUser.dokumentasi', compact('dokumentasi'));
    }
}
