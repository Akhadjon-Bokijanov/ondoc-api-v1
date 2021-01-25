<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'fullName' => $this->faker->name,
            'remember_token' => Str::random(10),
            'dateOfBirth'=> date('Y-m-d H:i:s', rand(12620500000,1262055681)),
            "gender"=>random_int(0, 1),
            "phone"=>random_int(800000000, 999999999),
            "lang"=>'uz',
            "tin"=>random_int(300000000, 999999999),
            "auth_key"=>Str::random(20),
            "status"=>1,
            "password"=>Hash::make("123456789"),
        ];
    }
}
