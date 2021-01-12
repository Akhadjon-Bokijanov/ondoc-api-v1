<?php

namespace Database\Factories;

use App\Models\Factura;
use App\Models\FacturaProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class FacturaProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FacturaProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
          "facturaProductId"=>Factura::all()->random(1)->first()->facturaProductId,
          "ordNo"=>$this->faker->numberBetween(1, 99),
          "committentName"=>$this->faker->name,
          "committentTin"=>$this->faker->numberBetween(300000000, 999999999),
          "vatRegCode"=>$this->faker->numberBetween(2000, 9999),
          "name"=>$this->faker->name,
          "catalogCode"=>$this->faker->numberBetween(1999, 99999999),
          "catalogName"=>$this->faker->name,
          "barCode"=>$this->faker->numberBetween(10000000, 99999999),
          "productType"=>$this->faker->numberBetween(1, 99),
          "serial"=>$this->faker->numberBetween(100000, 999999),
          "measureId"=>$this->faker->numberBetween(1, 50),
          "baseSumma"=>$this->faker->randomFloat(2, 10, 100000000),
          "profitRate"=>$this->faker->randomFloat(2, 1, 99),
          "count"=>$this->faker->numberBetween(1, 10000),
          "summa"=>$this->faker->randomFloat(2, 10000, 1000000000),
          "exciseRate"=>$this->faker->randomFloat(2, 1, 99),
          "exciseSum"=>$this->faker->randomFloat(2, 100, 10000000000),
          "deliverySum"=>$this->faker->randomFloat(2, 100, 999999999999),
          "vatRate"=>$this->faker->randomFloat(2, 1, 99),
          "deliverySumWithVat"=>$this->faker->randomFloat(2, 100, 999999999999),
          "withoutVat"=>$this->faker->numberBetween(0, 1),
          "created_at"=>now(),
        ];
    }
}
