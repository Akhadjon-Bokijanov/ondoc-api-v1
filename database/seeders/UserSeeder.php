<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
           'fio'=>Str::random(10) . " " . Str::random(10),
            'dateOfBirth'=> date('Y-m-d H:i:s', rand(12620500000,1262055681)),
            "gender"=>random_int(0, 1),
            "phone"=>random_int(800000000, 999999999),
            "lang"=>'uz',
            "tin"=>random_int(300000000, 999999999),
            "roleId"=>random_int(0, 5),
            "auth_key"=>Str::random(20),
            "status"=>1,
            "email"=>Str::random(9)."gmail.com",
            "password"=>Hash::make("123456789")
        ]);
    }
}
