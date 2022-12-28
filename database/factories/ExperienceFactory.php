<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ExperienceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
           'company' => 'Apple Inc - Germany',
           'period' => '2020 - 2022',
           'position' => 'Software Engineer',
        ];
    }
}
