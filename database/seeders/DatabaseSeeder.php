<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Factura;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         //\App\Models\User::factory(1000)->create();

        Company::factory(3000)->create();

         //Factura::factory(100)->create();
    }
}
