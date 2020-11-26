<?php

namespace Database\Factories;

use App\Models\Pharmacy;
use Illuminate\Database\Eloquent\Factories\Factory;

class PharmacyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pharmacy::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence,
            'region' => $this->faker->word,
            'area' => $this->faker->word,
            'address' => $this->faker->word,
            'additional_address' => $this->faker->word,
            'phone' => $this->faker->randomNumber(8),
            'am' => $this->faker->randomNumber(4)
        ];
    }
}
