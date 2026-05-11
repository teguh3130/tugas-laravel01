<?php

namespace Database\Factories;

use App\Models\Buku;
use App\Models\Anggota;
use Illuminate\Database\Eloquent\Factories\Factory;

class PeminjamanFactory extends Factory
{
    public function definition(): array
    {
        $tanggalPinjam = $this->faker->dateTimeBetween('-30 days', 'now');

        return [
            'buku_id'        => Buku::inRandomOrder()->first()->id,
            'anggota_id'     => Anggota::inRandomOrder()->first()->id,
            'tanggal_pinjam' => $tanggalPinjam,
            'tanggal_kembali'=> null,
            'status'         => 'dipinjam',
        ];
    }
}