<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    protected $table = 'anggotas';

    protected $fillable = [
        'nama',
        'alamat',
        'no_telepon',
    ];

    /**
     * Satu anggota bisa memiliki banyak peminjaman.
     */
    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'anggota_id');
    }

    /**
     * Peminjaman yang sedang aktif.
     */
    public function peminjamanAktif()
    {
        return $this->hasMany(Peminjaman::class, 'anggota_id')
                    ->where('status', 'dipinjam');
    }
}