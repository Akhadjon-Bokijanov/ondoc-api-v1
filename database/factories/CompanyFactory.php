<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "tin"=>$this->faker->unique()->numberBetween(200000000, 999999999),
            "companyName" =>$this->faker->company,
            "address"=>$this->faker->address,
            "oked"=>$this->faker->numberBetween(123, 9999),
            "tariffId"=>$this->faker->numberBetween(1, 10),
            "districtId"=>$this->faker->numberBetween(1, 100),
            "ns10Code"=>$this->faker->numberBetween(1000, 9999),
            "ns11Code"=>$this->faker->numberBetween(1000, 99999),
            "directorTin"=>$this->faker->numberBetween(200000000, 999999999),
            "directorName"=>$this->faker->name,
            "accountant"=>$this->faker->name,
            "regCode"=>$this->faker->numberBetween(20000000, 99999999),
            "mfo"=>$this->faker->numberBetween(1000, 9999),
            "phone"=>$this->faker->numberBetween(100000000, 999999999),
            "status"=>1,
            "type"=>$this->faker->numberBetween(1, 15),
            "isAferta"=>$this->faker->numberBetween(0,1),
            "isOnline"=>$this->faker->numberBetween(0,1),
            "countLogin"=>$this->faker->numberBetween(1, 10000),
            "lastLoginAt"=>$this->faker->dateTime,
            "afertaText"=>$this->faker->text,
        ];
    }
}
