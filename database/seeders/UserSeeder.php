<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {

        $dataRole = [
            ['name' => 'DKD', 'created_at' => now(), 'updated_at' => now(),],
            ['name' => 'DKR', 'created_at' => now(), 'updated_at' => now(),],
            ['name' => 'DKC', 'created_at' => now(), 'updated_at' => now(),],
            ['name' => 'User', 'created_at' => now(), 'updated_at' => now(),],
        ];
        foreach ($dataRole as $key => $value) {
            Role::create($value);
        }

        $roleDkd = Role::where('name', 'DKD')->first();
        $roleDkr = Role::where('name', 'DKR')->first();
        $roleDkc = Role::where('name', 'DKC')->first();
        $roleSA = Role::where('name', 'Super Admin')->first();
        
        $data   = [
            [
                'name'              => 'Super Admin',
                'fullname'          => 'Super Admin',
                'pob'               => 'Djakarta',
                'dob'               => '2000-10-10',
                'email'             => 'admin@mail.com',
                'password'          => bcrypt('12345678'),
                'role_id'           => $roleSA->id,
                'email_verified_at' => '2022-01-02 17:04:58',
                'avatar'            => 'images/avatar-1.jpg',
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'name'              => 'DKD',
                'fullname'          => 'DKD',
                'pob'               => 'Djakarta',
                'dob'               => '2000-10-10',
                'email'             => 'dkd@mail.com',
                'password'          => bcrypt('12345678'),
                'role_id'           => $roleDkd->id,
                'email_verified_at' => '2022-01-02 17:04:58',
                'avatar'            => 'images/avatar-1.jpg',
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'name'              => 'DKR',
                'fullname'          => 'DKR',
                'pob'               => 'Djakarta',
                'dob'               => '2000-10-10',
                'email'             => 'dkr@mail.com',
                'password'          => bcrypt('12345678'),
                'role_id'           => $roleDkr->id,
                'email_verified_at' => '2022-01-02 17:04:58',
                'avatar'            => 'images/avatar-1.jpg',
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'name'              => 'DKC',
                'fullname'          => 'DKC',
                'pob'               => 'Djakarta',
                'dob'               => '2000-10-10',
                'email'             => 'dkc@mail.com',
                'password'          => bcrypt('12345678'),
                'role_id'           => $roleDkc->id,
                'email_verified_at' => '2022-01-02 17:04:58',
                'avatar'            => 'images/avatar-1.jpg',
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
        ];

        foreach ($data as $key => $value) {
            User::create($value);
        }
    }
}
