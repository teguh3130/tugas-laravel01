<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with(['buku', 'anggota'])
                                  ->latest()
                                  ->paginate(10);
        return view('peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        $bukus    = Buku::where('stok', '>', 0)->orderBy('judul')->get();
        $anggotas = Anggota::orderBy('nama')->get();
        return view('peminjaman.create', compact('bukus', 'anggotas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'buku_id'        => 'required|exists:bukus,id',
            'anggota_id'     => 'required|exists:anggotas,id',
            'tanggal_pinjam' => 'required|date|before_or_equal:today',
            'tanggal_kembali'=> 'nullable|date|after_or_equal:tanggal_pinjam',
        ], [
            'buku_id.required'        => 'Buku wajib dipilih.',
            'buku_id.exists'          => 'Buku tidak ditemukan.',
            'anggota_id.required'     => 'Anggota wajib dipilih.',
            'anggota_id.exists'       => 'Anggota tidak ditemukan.',
            'tanggal_pinjam.required' => 'Tanggal pinjam wajib diisi.',
            'tanggal_pinjam.before_or_equal' => 'Tanggal pinjam tidak boleh melebihi hari ini.',
            'tanggal_kembali.after_or_equal' => 'Tanggal kembali harus setelah tanggal pinjam.',
        ]);

        // Gunakan DB transaction untuk keamanan data
        DB::transaction(function () use ($validated) {
            $buku = Buku::lockForUpdate()->findOrFail($validated['buku_id']);

            // Validasi stok saat ini
            if ($buku->stok < 1) {
                throw new \Exception('Stok buku habis, peminjaman tidak dapat dilakukan.');
            }

            // Buat record peminjaman
            Peminjaman::create([
                'buku_id'         => $validated['buku_id'],
                'anggota_id'      => $validated['anggota_id'],
                'tanggal_pinjam'  => $validated['tanggal_pinjam'],
                'tanggal_kembali' => $validated['tanggal_kembali'] ?? null,
                'status'          => 'dipinjam',
            ]);

            // Kurangi stok buku
            $buku->decrement('stok');
        });

        return redirect()->route('peminjaman.index')
                         ->with('success', 'Peminjaman berhasil dicatat & stok buku telah dikurangi!');
    }

    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load(['buku', 'anggota']);
        return view('peminjaman.show', compact('peminjaman'));
    }

    public function edit(Peminjaman $peminjaman)
    {
        $bukus    = Buku::orderBy('judul')->get();
        $anggotas = Anggota::orderBy('nama')->get();
        return view('peminjaman.edit', compact('peminjaman', 'bukus', 'anggotas'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        $validated = $request->validate([
            'tanggal_kembali' => 'nullable|date|after_or_equal:tanggal_pinjam',
            'status'          => 'required|in:dipinjam,dikembalikan',
        ], [
            'status.required'         => 'Status wajib dipilih.',
            'status.in'               => 'Status tidak valid.',
            'tanggal_kembali.after_or_equal' => 'Tanggal kembali harus setelah tanggal pinjam.',
        ]);

        DB::transaction(function () use ($validated, $peminjaman) {
            $statusLama = $peminjaman->status;
            $statusBaru = $validated['status'];

            // Jika status berubah dari 'dipinjam' menjadi 'dikembalikan'
            if ($statusLama === 'dipinjam' && $statusBaru === 'dikembalikan') {
                $peminjaman->buku->increment('stok');

                // Set tanggal kembali otomatis jika belum diisi
                if (empty($validated['tanggal_kembali'])) {
                    $validated['tanggal_kembali'] = now()->toDateString();
                }
            }

            // Jika status berubah balik dari 'dikembalikan' ke 'dipinjam' (koreksi data)
            if ($statusLama === 'dikembalikan' && $statusBaru === 'dipinjam') {
                $peminjaman->buku->decrement('stok');
                $validated['tanggal_kembali'] = null;
            }

            $peminjaman->update($validated);
        });

        return redirect()->route('peminjaman.index')
                         ->with('success', 'Status peminjaman berhasil diperbarui!');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        // Kembalikan stok jika masih berstatus dipinjam
        if ($peminjaman->status === 'dipinjam') {
            $peminjaman->buku->increment('stok');
        }

        $peminjaman->delete();

        return redirect()->route('peminjaman.index')
                         ->with('success', 'Data peminjaman berhasil dihapus!');
    }
}