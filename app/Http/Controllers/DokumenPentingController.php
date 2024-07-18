<?php

namespace App\Http\Controllers;

use App\Models\DokumenPenting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class DokumenPentingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $dokumenPenting = DokumenPenting::orderBy('updated_at', 'DESC')->get();
        return view('dokumenPenting.index', compact('dokumenPenting'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'file'  => 'required|mimes:pdf|max:10240',
        ], [
            'name.required' => 'Nama Dokumen harus diisi!',
            'file.required' => 'File harus diisi!',
            'file.mimes'    => 'File harus berupa pdf',
            'file.max'      => 'File tidak boleh lebih dari 10 MB',
        ]);
        if ($request->hasFile('file')) {
            $file   = $request->file('file');
            $filename = time() . '-' . $file->getClientOriginalName();
            $file->storeAs('public/dokumenPenting/', $filename);
            DokumenPenting::create(array_merge($request->all(), [
                'filename'  => $filename,
                'file'      => $file->getClientOriginalName(),
                'user_id'   => auth()->user()->id
            ]));
            Alert::success('Success!', 'Data Created Successfully');
            return redirect()->back();
        }
        Alert::success('Sucess!', 'Data Created Successfully');
        return back();
    }

    public function show(DokumenPenting $dokumenPenting)
    {
        return $dokumenPenting;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'file'  => 'mimes:pdf|max:10240',
        ], [
            'file.mimes' => 'File harus berupa pdf',
            'file.max'   => 'File tidak boleh lebih dari 10 MB',
        ]);
        $dokumenPenting = DokumenPenting::findOrFail($id);
        if ($request->hasFile('file')) {
            $file   = $request->file('file');
            $filename = time() . '-' . $file->getClientOriginalName();
            $file->storeAs('public/dokumenPenting/', $filename);
            Storage::delete('public/dokumenPenting/' . $dokumenPenting->filename);
            $dokumenPenting->update(array_merge($request->all(), [
                'filename'  => $filename,
                'file'      => $file->getClientOriginalName(),
                'user_id'   => auth()->user()->id
            ]));
        } else {
            $dokumenPenting->update(array_merge($request->all(), [
                'user_id'   => auth()->user()->id
            ]));
            Alert::success('Success!', 'Data Updated Successfully');
            return redirect()->back();
        }
        Alert::success('Success!', 'Data Updated Successfully');
        return back();
    }

    public function destroy($id)
    {
        $dokumenPenting = DokumenPenting::findOrFail($id);
        Storage::delete('public/dokumenPenting/' . $dokumenPenting->filename);
        $dokumenPenting->delete();
        Alert::success('Success!', 'Data Deleted Successfully');
        return back();
    }
}
