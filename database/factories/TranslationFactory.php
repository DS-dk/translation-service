<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TranslationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'locale' => $this->faker->randomElement(['en', 'fr', 'es']),
            'key' => $this->faker->word,
            'value' => $this->faker->sentence,
            'tags' => json_encode([$this->faker->randomElement(['web', 'desktop', 'mobile'])])
        ];
    }
}
