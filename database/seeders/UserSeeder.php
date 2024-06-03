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
        // DB::table('roles')->truncate();

        $dataRole = [
            ['name' => 'Super Admin', 'created_at' => now(), 'updated_at' => now(),],
            ['name' => 'Pinkonran', 'created_at' => now(), 'updated_at' => now(),],
            ['name' => 'Pinkoncab', 'created_at' => now(), 'updated_at' => now(),],
            ['name' => 'User', 'created_at' => now(), 'updated_at' => now(),],
        ];
        foreach ($dataRole as $key => $value) {
            Role::create($value);
        }

        $roleSA = Role::where('name', 'Super Admin')->first();
        $roleRan = Role::where('name', 'Pinkonran')->first();
        $roleCab = Role::where('name', 'Pinkoncab')->first();
        $roleU = Role::where('name', 'User')->first();
        
        $data   = [
            [
                'name'              => 'Super Admin',
                'fullname'          => 'Super Admin',
                'pob'               => 'Djakarta',
                'dob'               => '2000-10-10',
                'email'             => 'superadmin@mail.com',
                'password'          => bcrypt('12345678'),
                'role_id'           => $roleSA->id,
                'email_verified_at' => '2022-01-02 17:04:58',
                'avatar'            => 'images/avatar-1.jpg',
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'name'              => 'Admin',
                'fullname'          => 'Admin',
                'pob'               => 'Djakarta',
                'dob'               => '2000-10-10',
                'email'             => 'admin@mail.com',
                'password'          => bcrypt('12345678'),
                'role_id'           => $roleRan->id,
                'email_verified_at' => '2022-01-02 17:04:58',
                'avatar'            => 'images/avatar-1.jpg',
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'name'              => 'User',
                'fullname'          => 'User',
                'pob'               => 'Djakarta',
                'dob'               => '2000-10-10',
                'email'             => 'user@mail.com',
                'password'          => bcrypt('12345678'),
                'role_id'           => $roleU->id,
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
