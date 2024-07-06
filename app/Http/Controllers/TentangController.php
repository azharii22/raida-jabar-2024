<?php

namespace App\Http\Controllers;

use App\Models\Tentang;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class TentangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $tentang = Tentang::first();
        return view('tentang.index', compact('tentang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'foto'  => 'nullable|mimes:png,jpg,jpeg|max:2048',
            'name'  => 'required',
        ], [
            'foto.mimes'    => 'Format gambar harus png, jpg, atau jpeg',
            'foto.max'      => 'Ukuran gambar maksimal 2 MB',
            'name.required' => 'Isi Tentang Wajib Diisi!',
        ]);
        if ($request->file('foto')) {
            $image = $request->file('foto');
            $image->storeAs('public/viewUser/img/tentang', $image->hashName());
            Tentang::create(array_merge($request->all(), [
                'user_id'   => auth()->user()->id,
                'foto'      => $image->hashName()
            ]));
        }else{
            Tentang::create(array_merge($request->all(),[
                'user_id'   => auth()->user()->id,
            ]));
        }
        Alert::success('Success!', 'Data Success Created');
        return back();
    }

    public function show(Tentang $tentang)
    {
        return $tentang;
    }

    public function update(Request $request, $id)
    {
        $tentang = Tentang::findOrFail($id);
        $tentang->update($request->all());
        Alert::success('Success!', 'Data Success Updated');
        return back();
    }

    public function destroy($id)
    {
        Tentang::findOrFail($id)->delete();
        Alert::success('Success!', 'Data Success Deleted');
        return back();
    }
}
