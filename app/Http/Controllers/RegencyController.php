<?php

namespace App\Http\Controllers;

use App\Models\Regency;
use App\Models\Villages;
use Illuminate\Http\Request;

class RegencyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = Regency::where('name', 'LIKE', '%'.request('q').'%')->paginate(27);
        return response()->json($data);
    }

    public function villages($id)
    {
        $data = Villages::where('regency_id', $id)->where('name', 'LIKE', '%'.request('q').'%')->paginate(10);
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Regency  $regency
     * @return \Illuminate\Http\Response
     */
    public function show(Regency $regency)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Regency  $regency
     * @return \Illuminate\Http\Response
     */
    public function edit(Regency $regency)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Regency  $regency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Regency $regency)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Regency  $regency
     * @return \Illuminate\Http\Response
     */
    public function destroy(Regency $regency)
    {
        //
    }
}
