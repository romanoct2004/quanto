<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
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
        User::insert([
            "name" => "HIEN",
            "full_name" => "THHIEN",
            "email" => "tranhuuhien1990@gmail.com",
            "email_verified_at" => Carbon::now(),
            "password" => Hash::make("12345678Aa-"),
            "role_id" => 1
        ]);
    }
}
