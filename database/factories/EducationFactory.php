<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EducationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'institution' => 'Germany-University',
            'period' => '2010-2014',
            'degree' => 'Master of Science',
            'department' => 'Computer Science',
        ];
    }
}
