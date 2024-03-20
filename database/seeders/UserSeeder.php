<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Store Test',
            'email' => 'test@gmail.com',
            'password' => Hash::make('test123'),
            'phone_number' => '0123456789',
        ]);

        DB::table('users')->insert([
            'name' => 'Admin Test',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('test123'),
            'phone_number' => '01234567891',
        ]);
    }
}
