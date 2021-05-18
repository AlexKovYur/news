<?php

namespace Database\Factories;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

class CurrencyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Currency::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'currency' => $this->faker->currencyCode,
            'cost' => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 99),
            'change' => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 10)
        ];
    }
}
