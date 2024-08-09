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
        $village = Villages::inRandomOrder()->first();
        return [
            'user_id'           => User::inRandomOrder()->first()->id,
            'kategori_id'       => Kategori::inRandomOrder()->first()->id,
            'status_id'         => Status::inRandomOrder()->first()->id,
            'nama_lengkap'      => $this->faker->name(),
            'tempat_lahir'      => $this->faker->city(),
            'tanggal_lahir'     => $this->faker->date('Y-m-d', '2000-01-01'),
            'ukuran_kaos'       => $this->faker->randomElement(["S", "M", "L" ,"XL"]),
            'no_hp'             => $this->faker->phoneNumber(),
            'agama'             => $this->faker->randomElement(["Islam", "kristen", "Hindu"]),
            'golongan_darah'    => $this->faker->randomElement(["A", "B", "O"]),
            'jenis_kelamin'     => $this->faker->randomElement([1, 2]),
            'regency_id'        => $village->regency_id,
            'villages_id'       => $village->id,
        ];
    }
}
