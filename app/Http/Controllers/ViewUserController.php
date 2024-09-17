<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\DokumenPenting;
use App\Models\DokumentasiKegiatan;
use App\Models\ImageUpload;
use App\Models\JadwalKegiatan;
use App\Models\Kategori;
use App\Models\Kegiatan;
use App\Models\Peserta;
use App\Models\ReviewRating;
use App\Models\Tentang;
use App\Models\UnsurKontingen;
use Illuminate\Http\Request;

class ViewUserController extends Controller
{
    public function index()
    {
        $artikel            = Artikel::orderBy('updated_at', 'DESC')->paginate(10);
        $notKontingen       = Kategori::where('name', 'LIKE', 'Peserta')->first();
        $peserta            = Peserta::where('kategori_id', $notKontingen->id)->get();
        $kategoriNotPeserta = Kategori::whereNotIn('name', ['Peserta'])->pluck('id');
        $kontingen          = Peserta::whereIn('kategori_id', $kategoriNotPeserta)->get();
        return view('viewUser.index', compact(['artikel', 'peserta', 'kontingen']));
    }

    public function tentang()
    {
        $tentang = Tentang::first();
        return view('viewUser.tentang', compact('tentang'));
    }

    public function mediaUnduh()
    {
        $media = DokumenPenting::orderBy('updated_at', 'DESC')->get();
        return view('viewUser.media_unduh', compact('media'));
    }

    public function artikel()
    {
        $artikel = Artikel::orderBy('updated_at', 'DESC')->paginate(8);
        $artikelDesc = Artikel::with('user')->orderBy('updated_at', 'desc')->paginate(5);
        return view('viewUser.artikel', compact('artikel', 'artikelDesc'));
    }

    public function showArtikel($slug)
    {
        $artikel = Artikel::where('slug', $slug)->first();
        $comment = ReviewRating::with('artikel')->where('artikel_id', $artikel->id)->get();
        $artikelDesc = Artikel::with('user')->orderBy('updated_at', 'desc')->paginate(5);
        return view('viewUser.showArtikel', compact('artikel', 'comment', 'artikelDesc'));
    }

    public function reviewArtikelstore(Request $request, $slug)
    {
        $artikel = Artikel::where('slug', $slug)->first();
        // ReviewRating::create(array_merge($request->all()), [
        //     'artikel_id' => $artikel->id,
        //     'star_rating' => $request->rating,
        // ]);
        $review                 = new ReviewRating();
        $review->artikel_id     = $artikel->id;
        $review->comments       = $request->comment;
        $review->star_rating    = $request->rating;
        $review->nama           = $request->nama;
        $review->save();
        return redirect()->back()->with('success', 'Your review has been submitted Successfully,');
    }

    public function kegiatan()
    {
        $kegiatan = Kegiatan::orderBy('updated_at', 'DESC')->paginate(15);
        return view('viewUser.kegiatan', compact('kegiatan'));
    }
    public function jadwalKegiatan()
    {
        $jadwalKegiatan = JadwalKegiatan::orderBy('updated_at', 'DESC')->paginate(15);
        return view('viewUser.jadwal-kegiatan', compact('jadwalKegiatan'));
    }
    public function dokumentasi()
    {
        $dokumentasi = DokumentasiKegiatan::orderBy('updated_at', 'DESC')->paginate(10);
        return view('viewUser.dokumentasi', compact('dokumentasi'));
    }

    public function photo($id)
    {
        $photo = ImageUpload::where('dokumentasi_id', $id)->paginate(3);
        if (request()->ajax()) {
            return response()->json([
                'html' => view('viewUser.layouts.partials.photo-item', compact('photo'))->render()
            ]);
        }
        return view('viewUser.photo', compact('photo'));
    }


    public function download($id)
    {
        $photo = ImageUpload::findOrFail($id);
        $download = public_path('uploads/gallery/') . $photo->filename;
        return response()->download($download);
    }
}
