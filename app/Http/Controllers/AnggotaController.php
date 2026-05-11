<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggotas = Anggota::latest()->paginate(10);
        return view('anggota.index', compact('anggotas'));
    }

    public function create()
    {
        return view('anggota.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'       => 'required|string|max:255',
            'alamat'     => 'required|string',
            'no_telepon' => 'required|string|max:20|regex:/^[0-9\-\+\s]+$/',
        ], [
            'nama.required'        => 'Nama anggota wajib diisi.',
            'alamat.required'      => 'Alamat wajib diisi.',
            'no_telepon.required'  => 'Nomor telepon wajib diisi.',
            'no_telepon.regex'     => 'Format nomor telepon tidak valid.',
            'no_telepon.max'       => 'Nomor telepon maksimal 20 karakter.',
        ]);

        Anggota::create($validated);

        return redirect()->route('anggota.index')
                         ->with('success', 'Anggota berhasil ditambahkan!');
    }

    public function show(Anggota $anggota)
    {
        $anggota->load('peminjamans.buku');
        return view('anggota.show', compact('anggota'));
    }

    public function edit(Anggota $anggota)
    {
        return view('anggota.edit', compact('anggota'));
    }

    public function update(Request $request, Anggota $anggota)
    {
        $validated = $request->validate([
            'nama'       => 'required|string|max:255',
            'alamat'     => 'required|string',
            'no_telepon' => 'required|string|max:20|regex:/^[0-9\-\+\s]+$/',
        ]);

        $anggota->update($validated);

        return redirect()->route('anggota.index')
                         ->with('success', 'Data anggota berhasil diperbarui!');
    }

    public function destroy(Anggota $anggota)
    {
        $sedangMeminjam = $anggota->peminjamans()->where('status', 'dipinjam')->exists();
        if ($sedangMeminjam) {
            return back()->with('error', 'Anggota tidak dapat dihapus karena masih memiliki peminjaman aktif!');
        }

        $anggota->delete();

        return redirect()->route('anggota.index')
                         ->with('success', 'Anggota berhasil dihapus!');
    }
}