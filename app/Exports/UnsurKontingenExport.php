<?php

namespace App\Exports;

use App\Models\UnsurKontingen;
use Maatwebsite\Excel\Concerns\FromCollection;

class UnsurKontingenExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return UnsurKontingen::all();
    }
}
