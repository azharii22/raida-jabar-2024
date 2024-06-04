<?php

namespace App\Exports;

use App\Models\UnsurKontingen;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UnsurKontingenAdminExport implements FromView
{
    public function view(): View
    {
        return view('unsurKontingen.admin-excel', [
            'peserta' => UnsurKontingen::orderBy('nama_lengkap', 'ASC')->get()
        ]);
    }
}
