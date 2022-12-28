<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TestimonialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Jay Smith',
            'function' => 'Costumer',
            'testimony' => 'I got a good testimony',
            'rating' => '4',
            'photo' => 'avatar.png',
        ];
    }
}
