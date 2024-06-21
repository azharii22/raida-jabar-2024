<?php

namespace App\Http\Controllers;

use App\Models\Villages;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class VillagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $region = Villages::orderBy('regency_id')->get();
        return view('region.index', compact('region'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'regency_id'    => 'required',
            'name'          => 'required',
        ], [
            'regency_id.required'   => 'Kabupaten/Kota tidak boleh kosong',
            'name.required'         => 'Nama Kelurahan tidak boleh kosong',
        ]);
        Villages::create($request->all());
        Alert::success('Success!', 'Data Success Created');
        return back();
    }

    public function update(Request $request, $id)
    {
        $villages = Villages::findOrFail($id);
        $request->validate([
            'regency_id'    => 'required',
            'name'          => 'required',
        ], [
            'regency_id.required'   => 'Kabupaten/Kota tidak boleh kosong',
            'name.required'         => 'Nama Kelurahan tidak boleh kosong',
        ]);
        $villages->update($request->all());
        Alert::success('Success!', 'Data Success Updated');
        return back();
    }

    public function destroy($id)
    {
        $villages = Villages::findOrFail($id);
        $villages->delete();
        Alert::success('Success!', 'Data Success Deleted');
        return back();
    }
}
