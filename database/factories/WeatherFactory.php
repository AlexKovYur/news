<?php

namespace Database\Factories;

use App\Models\Weather;
use Illuminate\Database\Eloquent\Factories\Factory;

class WeatherFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Weather::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'city' => $this->faker->city,
            'tempurature' => $this->faker->numberBetween(10,20),
            'description' => $this->faker->randomElement($array = ['Малооблачно','Облачно','Солнечно']),
            'humidity' => $this->faker->numberBetween(10,90),
            'source' => 'https://www.gismeteo.ru'
        ];
    }
}
