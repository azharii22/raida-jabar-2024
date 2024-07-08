<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Bindamping'],
            ['name' => 'Peserta'],
            ['name' => 'Pinkoncab'],
            ['name' => 'Pinkonran'],
            ['name' => 'Staff Kontingen'],
            ['name' => 'Tenaga Medis'],
        ];
        foreach ($data as $key => $value) {
            Kategori::create($value);
        }
    }
}
