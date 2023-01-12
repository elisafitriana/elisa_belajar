<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'email'=>'admin@admin.com',
            'password'=>bcrypt('password'),
            'role'=>'admin'
        ]);

        User::factory()->create([
            'email'=>'user@admin.com',
            'password'=>bcrypt('password'),
            'role'=>'user'
        ]);
    }
}
