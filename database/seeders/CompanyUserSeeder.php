<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        for ($i=1; $i<=3100; $i++){
            DB::table('company_user')->insert([
                "user_id"=>random_int(1, 1000),
                "company_id"=>random_int(1, 3006),
                "roleId"=>random_int(1, 5),
                "isActive"=>1
            ]);
        }
    }
}
