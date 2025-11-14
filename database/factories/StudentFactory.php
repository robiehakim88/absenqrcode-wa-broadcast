<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'parent_phone' => '08' . $this->faker->numerify('##########'),
            // NIS dan classroom_id akan diisi langsung oleh Seeder
        ];
    }
}