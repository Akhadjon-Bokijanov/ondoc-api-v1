<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Factura;
use App\Models\FacturaProduct;
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
        //\App\Models\User::factory(100)->create();

        //Company::factory(100)->create();

        Factura::factory(1000)->create();

        //FacturaProduct::factory(500)->create();
    }
}
