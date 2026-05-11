<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AnggotaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama'       => $this->faker->name('male') . ' ' . $this->faker->lastName(),
            'alamat'     => $this->faker->address(),
            'no_telepon' => '08' . $this->faker->numerify('#########'),
        ];
    }
}