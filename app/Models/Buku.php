<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'bukus';

    protected $fillable = [
        'judul',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'stok',
    ];

    protected $casts = [
        'tahun_terbit' => 'integer',
        'stok'         => 'integer',
    ];

    /**
     * Satu buku bisa dipinjam berkali-kali.
     */
    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'buku_id');
    }

    /**
     * Cek apakah stok tersedia.
     */
    public function isAvailable(): bool
    {
        return $this->stok > 0;
    }
}