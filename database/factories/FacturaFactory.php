<?php

namespace Database\Factories;

use App\Models\Factura;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class FacturaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Factura::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {
        return [
            "facturaId"=>Str::random(24),
            "version"=>1,
            "singleSidedType"=>$this->faker->numberBetween(0,1),
            "facturaNo"=>$this->faker->numberBetween(1, 100),
            "facturaDate"=>$this->faker->dateTime,
            "oldFacturaId"=>Str::random(24),
            "oldFacturaNo"=>$this->faker->numberBetween(1, 100),
            "oldFacturaDate"=>$this->faker->dateTime,
            "facturaProductId"=>Str::random(24),
            "notes"=>$this->faker->text,
          "facturaType"=>$this->faker->numberBetween(1, 25),
          "currentStateid"=>$this->faker->numberBetween(1, 5),
          "lotId"=>$this->faker->numberBetween(1,10),
          "inCallBack"=>$this->faker->numberBetween(0,1),
          "hasVat"=>$this->faker->numberBetween(0,1),
          "hasExcise"=>$this->faker->numberBetween(0,1),
          "hasMarking"=>$this->faker->numberBetween(0,1),
          "hasMedical"=>$this->faker->numberBetween(0,1),
          "contractNo"=>$this->faker->numberBetween(300, 1000),
          "contractDate"=>$this->faker->dateTime,
          "empowermentNo"=>$this->faker->numberBetween(1, 100),
          "empowermentDateOfIssue"=>$this->faker->dateTime,
          "agentFio"=>$this->faker->name,
          "agentTin"=>$this->faker->numberBetween(300000000, 99999999),
          "agentFacturaId"=>Str::random(24),
          "itemReleasedFio"=>$this->faker->name,
          "itemReleaseTin"=>$this->faker->numberBetween(300000000, 999999999),
          "itemReleasePinf1"=>Str::random(100),
          "sellerTin"=>$this->faker->numberBetween(300000000, 999999999),
          "buyerTin"=>$this->faker->numberBetween(300000000, 999999999),
          "sellerAccount"=>$this->faker->bankAccountNumber,
          "sellerBankId"=>$this->faker->numberBetween(1, 100),
          "sellerName"=>$this->faker->name,
          "sellerAddress"=>$this->faker->address,
          "sellerMobilePhone"=>$this->faker->numberBetween(900000000, 999999999),
          "sellerWorkPhone"=>$this->faker->numberBetween(900000000, 999999999),
          "sellerOked"=>$this->faker->numberBetween(1000, 9999),
          "sellerDistrictId"=>$this->faker->numberBetween(1000, 9999),
          "sellerDirector"=>$this->faker->name,
          "sellerAccountant"=>$this->faker->name,
          "sellerVatRegCode"=>$this->faker->numberBetween(100, 1000),
          "sellerBranchName"=>$this->faker->company,
          "sellerBranchCode"=>$this->faker->numberBetween(1000, 9999),
          "buyerAccount"=>$this->faker->bankAccountNumber,
          "buyerBankId"=>$this->faker->numberBetween(100, 9900),
          "buyerName"=>$this->faker->name,
          "buyerAddress"=>$this->faker->address,
          "buyerMobilePhone"=>$this->faker->numberBetween(901000000, 999999999),
          "buyerWorkPhone"=>$this->faker->numberBetween(901000000, 999999999),
          "buyerOked"=>$this->faker->numberBetween(100, 1000),
          "buyerDistrictId"=>$this->faker->numberBetween(100, 999),
          "buyerDirector"=>$this->faker->name,
          "buyerAccountant"=>$this->faker->name,
          "buyerVatRegCode"=>$this->faker->numberBetween(102, 9999),
          "buyerBranchName"=>$this->faker->company,
          "buyerBranchCode"=>$this->faker->numberBetween(1000, 9999),
          "created_at"=>now(),
          "updated_at"=>now(),
        ];
    }
}
