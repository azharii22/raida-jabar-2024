<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class ArtikelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $artikel = Artikel::orderBy('updated_at', 'DESC')->get();
        return view('artikel.index', compact('artikel'));
    }

    public function create()
    {
        return view('artikel.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'         => 'required|max:255',
            'deskripsi'     => 'required|max:255',
            'foto'          => 'required|mimes:png,jpg,jpeg|max:2048',
            'isi_artikel'   => 'required',
        ], [
            'judul.required'        => 'Judul Wajib Diisi!',
            'judul.max'             => 'Judul Maximal 255 karakter!',
            'deskripsi.required'    => 'Deskripsi Wajib Diisi!',
            'deskripsi.max'         => 'Deskripsi Maximal 255 karakter!',
            'foto.required'         => 'Foto Wajib Diisi!',
            'foto.mimes'            => 'Format gambar harus png, jpg, atau jpeg',
            'foto.max'              => 'Ukuran gambar maksimal 2 MB',
            'isi_artikel.required'  => 'Isi Artikel Wajib Diisi!',
        ]);
        $image = $request->file('foto');
        $image->storeAs('public/img/artikel', $image->hashName());
        Artikel::create(array_merge($request->all(), [
            'user_id' => auth()->user()->id,
            'slug' => Str::slug($request->judul),
            'foto' => $image->hashName()
        ]));
        Alert::success('Success!', 'Data Created Succesfully');
        return redirect()->route('admin-artikel.index')->with('success', 'Data has been created');
    }

    function edit($slug)
    {
        $artikel = Artikel::with('user')->where('slug', $slug)->firstOrFail();
        return view('artikel.edit', compact('artikel'));
    }

    public function show($slug)
    {
        $artikel = Artikel::with('user')->where('slug', $slug)->firstOrFail();
        return view('artikel.show', compact('artikel'));
    }

    public function update(Request $request, $slug)
    {
        $request->validate([
            'judul'         => 'required|max:255',
            'deskripsi'     => 'required|max:255',
            'foto'          => 'nullable|mimes:png,jpg,jpeg|max:2048',
            'isi_artikel'   => 'required',
        ], [
            'judul.required'        => 'Judul Wajib Diisi!',
            'judul.max'             => 'Judul Maximal 255 karakter!',
            'deskripsi.required'    => 'Deskripsi Wajib Diisi!',
            'deskripsi.max'         => 'Deskripsi Maximal 255 karakter!',
            'foto.mimes'            => 'Format gambar harus png, jpg, atau jpeg',
            'foto.max'              => 'Ukuran gambar maksimal 2 MB',
            'isi_artikel.required'  => 'Isi Artikel Wajib Diisi!',
        ]);
        $artikel = Artikel::with('user')->where('slug', $slug)->firstOrFail();
        if ($request->hasFile('foto')) {

            $image = $request->file('foto');
            $image->storeAs('public/img/artikel', $image->hashName());
            Storage::delete('public/img/artikel/' . $artikel->foto);
            $artikel->update(array_merge($request->all(), [
                'foto'      => $image->hashName(),
                'user_id'   => auth()->user()->id,
                'slug'      => Str::slug($request->judul)
            ]));
        } else {
            $artikel->update(array_merge($request->all(), [
                'user_id'   => auth()->user()->id,
                'slug'      => Str::slug($request->judul)
            ]));
        };
        Alert::success('Success!', 'Data Updated Succesfully');
        return redirect()->route('admin-artikel.index')->with('success', 'Data has been updated');
    }

    public function destroy($slug)
    {
        $artikel = Artikel::with('user')->where('slug', $slug)->firstOrFail();
        $artikel->delete();
        Alert::success('Success!', 'Data Deleted Succesfully');
        return redirect()->back()->with('success', 'Data has been deleted');
    }
}
