<?php

namespace App\Http\Controllers;

use App\Models\Berkas;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class BerkasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::user()->role_id == 1) {
            $berkas = Berkas::with('status', 'user')->orderBy('updated_at', 'DESC')->get();
            $status = Status::orderBy('name', 'ASC')->get();
        } else {
            $berkas = Berkas::with('status', 'user')->where('user_id', Auth::user()->id)->orderBy('updated_at', 'DESC')->get();
            $status = Status::orderBy('name', 'ASC')->get();
        }
        return view('berkas.index', compact('berkas','status'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file'  => 'required|mimes:pdf|max:2048',
        ], [
            'file.required' => 'File harus diisi!',
            'file.mimes'    => 'File harus berupa pdf',
            'file.max'      => 'File tidak boleh lebih dari 2 MB',
        ]);
        $file   = $request->file('file');
        $filename = time() . '-' . $file->getClientOriginalName();
        $file->storeAs('public/berkas/', $filename);
        $status = Status::where('name', 'Terkirim')->first();
        Berkas::create(array_merge($request->all(), [
            'filename'  => $filename,
            'file'      => $file->getClientOriginalName(),
            'user_id'   => Auth::user()->id,
            'status_id' => $status->id
        ]));

        Alert::success('Sucess!', 'Data Created Successfully');
        return back();
    }

    public function show(Berkas $berkas)
    {
        return $berkas;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'file'  => 'mimes:pdf|max:2048',
        ], [
            'file.mimes' => 'File harus berupa pdf',
            'file.max'   => 'File tidak boleh lebih dari 2 MB',
        ]);
        $berkas = Berkas::findOrFail($id);
        $status = Status::where('name', 'Terkirim')->first();
        if ($request->hasFile('file')) {
            $file   = $request->file('file');
            $filename = time() . '-' . $file->getClientOriginalName();
            $file->storeAs('public/berkas/', $filename);
            Storage::delete('public/berkas/' . $berkas->filename);
            $berkas->update(array_merge($request->all(), [
                'filename'  => $filename,
                'file'      => $file->getClientOriginalName(),
                'user_id'   => Auth::user()->id,
                'status_id' => $status->id
            ]));
        } else {
            $berkas->update(array_merge($request->all(), [
                'user_id'   => Auth::user()->id,
                'status_id' => $status->id
            ]));
            return redirect()->back();
        }
        Alert::success('Success!', 'Data Updated Successfully');
        return back();
    }

    public function destroy($id)
    {
        $berkas = Berkas::findOrFail($id);
        Storage::delete('public/berkas/' . $berkas->filename);
        $berkas->delete();
        Alert::success('Success!', 'Data Deleted Successfully');
        return back();
    }

    public function verifikasi(Request $request, $id)
    {
        $detail = Berkas::find($id);
        $detail->update($request->all());
        Alert::success('Success!', 'Status has been updated');
        return back();
    }
}
