<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class KegiatanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $kegiatan = Kegiatan::orderBy('updated_at')->get();
        return view('kegiatan.index', compact('kegiatan'));
    }

    public function create()
    {
        return view('kegiatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'     => 'required',
            'item_giat' => 'required',
        ], [
            'judul.required'     => 'Judul Wajib Diisi!',
            'item_giat.required' => 'Item Giat Wajib Diisi!'
        ]);
        Kegiatan::create(array_merge($request->all(), [
            'user_id'   => auth()->user()->id
        ]));
        Alert::success('Success!', 'Data Created Successfully');
        return redirect()->route('admin-kegiatan.index');
    }

    public function show(Kegiatan $kegiatan)
    {
        return $kegiatan;
    }

    public function edit($id)
    {
        $kegiatan = Kegiatan::find($id);
        return view('kegiatan.edit', compact('kegiatan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul'     => 'required',
            'item_giat' => 'required',
        ], [
            'judul.required'     => 'Judul Wajib Diisi!',
            'item_giat.required' => 'Item Giat Wajib Diisi!'
        ]);
        $kegiatan = Kegiatan::findOrFail($id);
        $kegiatan->update(array_merge($request->all(), [
            'user_id' => auth()->user()->id
        ]));
        Alert::success('Success!', 'Data Updated Successfully');
        return redirect()->route('admin-kegiatan.index');
    }

    public function destroy($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        $kegiatan->delete();
        Alert::success('Success!', 'Data Deleted Successfully');
        return back();
    }
}
