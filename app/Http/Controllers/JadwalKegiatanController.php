<?php

namespace App\Http\Controllers;

use App\Models\JadwalKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class JadwalKegiatanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $jadwalKegiatan = JadwalKegiatan::orderBy('updated_at', 'Desc')->get();
        return view('jadwalKegiatan.index', compact('jadwalKegiatan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_giat'  => 'required',
            'file'          => 'required|mimes:pdf|max:10240',
        ], [
            'tanggal_giat.required' => 'Tanggal kegiatan harus diisi!',
            'file.required'         => 'File harus diisi!',
            'file.mimes'            => 'File harus berupa pdf',
            'file.max'              => 'File tidak boleh lebih dari 10 MB',
        ]);
        if ($request->hasFile('file')) {
            $file   = $request->file('file');
            $filename = time() . '-' . $file->getClientOriginalName();
            $file->storeAs('public/jadwalKegiatan/', $filename);
            JadwalKegiatan::create(array_merge($request->all(), [
                'filename'  => $filename,
                'file'      => $file->getClientOriginalName(),
                'user_id'   => Auth::user()->id
            ]));
            Alert::success('Success!', 'Data Created Successfully');
            return redirect()->back();
        }
        Alert::success('Sucess!', 'Data Created Successfully');
        return back();
    }

    public function show(JadwalKegiatan $jadwalKegiatan)
    {
        return $jadwalKegiatan;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'file'          => 'mimes:pdf|max:10240',
        ], [
            'file.mimes'            => 'File harus berupa pdf',
            'file.max'              => 'File tidak boleh lebih dari 10 MB',
        ]);
        $jadwalKegiatan = JadwalKegiatan::findOrFail($id);
        if ($request->hasFile('file')) {
            $file   = $request->file('file');
            $filename = time() . '-' . $file->getClientOriginalName();
            $file->storeAs('public/jadwalKegiatan/', $filename);
            Storage::delete('public/jadwalKegiatan/' . $jadwalKegiatan->filename);
            $jadwalKegiatan->update(array_merge($request->all(), [
                'filename'  => $filename,
                'file'      => $file->getClientOriginalName(),
                'user_id'   => Auth::user()->id
            ]));
        } else {
            $jadwalKegiatan->update(array_merge($request->all(), [
                'user_id'   => Auth::user()->id
            ]));
            Alert::success('Success!', 'Data Updated Successfully');
            return redirect()->back();
        }
        Alert::success('Success!', 'Data Updated Successfully');
        return back();
    }

    public function destroy($id)
    {
        $jadwalKegiatan = JadwalKegiatan::findOrFail($id);
        Storage::delete('public/jadwalKegiatan/' . $jadwalKegiatan->filename);
        $jadwalKegiatan->delete();
        Alert::success('Success!', 'Data Deleted Successfully');
        return back();
    }
}
