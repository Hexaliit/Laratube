<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => 'SemCourse',
            'description' => 'Semnan University Course Website',
            'link' => 'https://github.com/hexaliit',
            'photo' => 'avatar.png',
        ];
    }
}
