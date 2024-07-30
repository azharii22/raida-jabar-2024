<?php

namespace App\Http\Controllers;

use App\Models\Villages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class VillagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // $region = Villages::orderBy('regency_id')->get();
        // return view('region.index', compact('region'));
        if ($request->ajax()) {
            $data = Villages::with('regency')->select(['id', 'name', 'regency_id', 'created_at']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('regency_name', function ($row) {
                    return $row->regency ? $row->regency->name : '';
                })
                ->addColumn('action', function($row){
                    $btn = '<button type="button" data-id="'.$row->id.'" class="edit btn btn-warning btn-sm mr-2 waves-effect waves-light"> <i class=" bx bx-pencil"></i>Edit</button>';
                    $btn .= ' <button type="button" data-id="'.$row->id.'" class="delete btn btn-danger btn-sm mr-2 waves-effect waves-light"> <i class=" bx bx-trash"></i>Delete</button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('region.index');
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
