<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BukuFactory extends Factory
{
    public function definition(): array
    {
        $penulis = [
            'Andrea Hirata', 'Pramoedya Ananta Toer', 'Dee Lestari',
            'Habiburrahman El Shirazy', 'Tere Liye', 'Raditya Dika',
            'Asma Nadia', 'NH Dini', 'Mira W', 'Ayu Utami',
        ];

        $penerbit = [
            'Gramedia Pustaka Utama', 'Bentang Pustaka', 'Mizan',
            'Republika Penerbit', 'Qanita', 'Erlangga', 'Grasindo',
        ];

        return [
            'judul'       => $this->faker->sentence(rand(2, 5), false),
            'penulis'     => $this->faker->randomElement($penulis),
            'penerbit'    => $this->faker->randomElement($penerbit),
            'tahun_terbit'=> $this->faker->numberBetween(1995, 2023),
            'stok'        => $this->faker->numberBetween(2, 15),
        ];
    }
}