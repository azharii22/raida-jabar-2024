<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Peserta;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $peserta = Peserta::paginate(4);
        return view('test-card', compact('peserta'));
    }
}
