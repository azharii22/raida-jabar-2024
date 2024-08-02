<?php

namespace Database\Factories;

use App\Models\Kategori;
use App\Models\Peserta;
use App\Models\Regency;
use App\Models\Status;
use App\Models\User;
use App\Models\Villages;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Peserta>
 */
class PesertaFactory extends Factory
{
    protected $model = Peserta::class;

    public function definition()
    {
        return [
            'user_id'       => User::inRandomOrder()->first()->id,
            'kategori_id'   => Kategori::inRandomOrder()->first()->id,
            'status_id'     => Status::inRandomOrder()->first()->id,
            'nama_lengkap'  => $this->faker->name(),
            'regency_id'    => Regency::inRandomOrder()->first()->id,
        ];
    }
}
