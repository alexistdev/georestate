<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $date = Carbon::now()->format('Y-m-d H:i:s');
        $user = [
            array('role_id' => '1','name' => 'superadmin',  'email' => 'archilles@gmail.com','password' => Hash::make('P@ssw0rd'),'created_at' => $date,'updated_at' => $date),
            array('role_id' => '2','name' => 'admin',  'email' => 'admin@gmail.com','password' => Hash::make('1234'),'created_at' => $date,'updated_at' => $date),
            array('role_id' => '3','name' => 'agen',  'email' => 'agen@gmail.com','password' => Hash::make('1234'),'created_at' => $date,'updated_at' => $date),
            array('role_id' => '4','name' => 'user',  'email' => 'user@gmail.com','password' => Hash::make('1234'),'created_at' => $date,'updated_at' => $date),
        ];
        User::insert($user);
    }
}
