<?php

namespace App\Http\Controllers;

use App\Models\Regency;
use App\Models\Villages;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class RegencyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $regencies = Regency::all(['id', 'name']); // Pastikan hanya mengambil id dan name
        return response()->json($regencies);
    }

    public function villages($id)
    {
        $data = Villages::where('regency_id', $id)->where('name', 'LIKE', '%'.request('q').'%')->paginate(10);
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'regency_id' => 'required|exists:regencies,id',
        ]);

        Villages::create($validatedData);
        Alert::success('Success!', 'Data Created SuccessFully');
        return response()->json(['success' => 'Data added successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Regency  $regency
     * @return \Illuminate\Http\Response
     */
    public function show(Regency $regency)
    {
        return $regency;
    }

    public function edit($id)
    {
        $data = Villages::find($id);
        $regencies = Regency::all(); 
        return response()->json([
            'data' => $data,
            'regencies' => $regencies
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = Villages::find($id);
        $data->update($request->all());
        Alert::success('Success!', 'Data Updated SuccessFully');
        return response()->json(['success' => 'Data updated successfully']);
    }

    public function destroy($id)
    {
        Villages::find($id)->delete();
        Alert::success('Success!', 'Data Deleted SuccessFully');
        return response()->json(['success' => 'Data deleted successfully']);
    }
}
