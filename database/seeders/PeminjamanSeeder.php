<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Database\Seeder;

class PeminjamanSeeder extends Seeder
{
    public function run(): void
    {
        // Buat 5 peminjaman, kurangi stok buku setiap peminjaman
        Peminjaman::factory()->count(5)->create()->each(function ($peminjaman) {
            $buku = Buku::find($peminjaman->buku_id);
            if ($buku && $buku->stok > 0) {
                $buku->decrement('stok');
            }
        });
    }
}