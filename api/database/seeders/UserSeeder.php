<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(!User::where('email', 'jjosenetto2020@gmail.com')->first()){
            User::create([
                'name' => 'Neto',
                'email' => 'jjosenetto2020n@gmail.com',
                'password' => Hash::make('123456a', ['round' => 12]),
                'birthday' => '18/09/2003',
            ]);
        }
    }
}
