<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class RegionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $region = Region::orderBy('dkc_name', 'ASC')->get();
        return view('region.index', compact('region'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dkc_name'  => 'required|string',
            'dkr_name'  => 'required|string',
        ], [
            'dkc_name.required' => 'Nama DKC tidak boleh kosong',
            'dkr_name.required' => 'Nama DKR tidak boleh kosong',
        ]);
        Region::create($request->all());
        Alert::success('Success!', 'Data Created Successfully');
        return back();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'dkc_name'  => 'required|string',
            'dkr_name'  => 'required|string',
        ], [
            'dkc_name.required' => 'Nama DKC tidak boleh kosong',
            'dkr_name.required' => 'Nama DKR tidak boleh kosong',
        ]);
        $region = Region::find($id);
        $region->update($request->all());
        Alert::success('Success!', 'Data Updated Successfully');
        return back();
    }

    public function destroy($id)
    {
        $region = Region::findOrFail($id);
        $region->delete();
        Alert::success('Success!', 'Data Success Deleted');
        return back();
    }
}
