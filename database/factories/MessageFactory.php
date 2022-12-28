<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Jayne Smith',
            'email' => 'jaynesmith@gmail.com',
            'subject' => 'Jayne Smith Subject',
            'description' => 'Jayne Smith Description Here',
            'status' => '0',
        ];
    }
}
