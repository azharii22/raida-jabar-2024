<?php

namespace App\Http\Controllers;

use App\Models\DokumentasiKegiatan;
use App\Models\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class DokumentasiKegiatanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DokumentasiKegiatan::get();
        return view('dokumentasiKegiatan.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dokumentasiKegiatan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'cover' => 'required|mimes:png,jpg,jpeg|max:10240',
        ], [
            'judul.required'    => 'Judul Dokumentasi Kegiatan harus diisi!',
            'judul.max'         => 'Judul Dokumentasi Kegiatan maksimal 255 karakter!',
            'cover.required'    => 'Cover Dokumentasi Kegiatan harus diisi!',
            'cover.mimes'       => 'Cover Dokumentasi Kegiatan harus berupa file png, jpg, jpeg!',
            'cover.max'         => 'Cover Dokumentasi Kegiatan maksimal 10 MB!',
        ]);

        if ($request->hasFile('cover')) {
            $cover   = $request->file('cover');
            $cover->storeAs('public/img/dokumentasi/cover', $cover->getClientOriginalName());
            DokumentasiKegiatan::create(array_merge($request->all(), [
                'user_id' => Auth::user()->id,
                'cover'      => $cover->getClientOriginalName()
            ]));
        } else {
            DokumentasiKegiatan::create(array_merge($request->all(), [
                'user_id' => Auth::user()->id,
            ]));
        }
        Alert::success('Success', 'Data Created Successfully');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DokumentasiKegiatan  $dokumentasiKegiatan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = ImageUpload::where('dokumentasi_id', $id)->get();
        return view('dokumentasiKegiatan.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DokumentasiKegiatan  $dokumentasiKegiatan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dokumentasiKegiatan = DokumentasiKegiatan::findOrFail($id);
        return view('dokumentasiKegiatan.edit', compact('dokumentasiKegiatan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DokumentasiKegiatan  $dokumentasiKegiatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'cover' => 'mimes:png,jpg,jpeg|max:10240',
        ], [
            'judul.required'    => 'Judul Dokumentasi Kegiatan harus diisi!',
            'judul.max'         => 'Judul Dokumentasi Kegiatan maksimal 255 karakter!',
            'cover.required'    => 'Cover Dokumentasi Kegiatan harus diisi!',
            'cover.mimes'       => 'Cover Dokumentasi Kegiatan harus berupa file png, jpg, jpeg!',
            'cover.max'         => 'Cover Dokumentasi Kegiatan maksimal 10 MB!',
        ]);

        $dokumentasiKegiatan = DokumentasiKegiatan::findOrFail($id);
        if ($request->hasFile('cover')) {
            $cover   = $request->file('cover');
            Storage::delete('public/img/dokumentasi/cover', $dokumentasiKegiatan->cover());
            $cover->storeAs('public/img/dokumentasi/cover', $cover->getClientOriginalName());
            $dokumentasiKegiatan->update(array_merge($request->all(), [
                'user_id' => Auth::user()->id,
                'cover'      => $cover->getClientOriginalName()
            ]));
        } else {
            $dokumentasiKegiatan->update(array_merge($request->all(), [
                'user_id' => Auth::user()->id,
            ]));
        }
        Alert::success('Success', 'Data Updated Successfully');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DokumentasiKegiatan  $dokumentasiKegiatan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dokumentasiKegiatan = DokumentasiKegiatan::findOrFail($id);
        Storage::delete('public/img/dokumentasi/cover' . $dokumentasiKegiatan->cover);
        $dokumentasiKegiatan->delete();
        Alert::success('Success!', 'Data Deleted Successfully');
        return back();
    }
}
