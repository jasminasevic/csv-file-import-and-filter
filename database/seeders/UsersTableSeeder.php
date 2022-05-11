<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'first_name' => 'Jasmina',
                'last_name' => 'Sevic',
                'email' => 'jasmina@gmail.com',
                'password' => bcrypt('jasmina123'),
                'role_id' => 1
            ],
            [
                'first_name' => 'Nikola',
                'last_name' => 'Glisovic',
                'email' => 'nikola@gmail.com',
                'password' => bcrypt('nikola123'),
                'role_id' => 1
            ],
            [
                'first_name' => 'Pera',
                'last_name' => 'Peric',
                'email' => 'pera@gmail.com',
                'password' => bcrypt('pera123'),
                'role_id' => 2
            ],
            [
                'first_name' => 'Mika',
                'last_name' => 'Mikic',
                'email' => 'mika@gmail.com',
                'password' => bcrypt('mika123'),
                'role_id' => 2
            ],
        ];

        foreach ($users as $key=>$value) {
            User::create($value);
        }
    }
}
