<?php

namespace Database\Seeders;

use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::insert([
            "name" => "HIEN CUSTOMER",
            "kana" => "THHIEN C KANA",
            "email" => "hiencustomer@gmail.com",
            "email_verified_at" => Carbon::now(),
            "password" => Hash::make("12345678Aa-")
        ]);
    }
}
