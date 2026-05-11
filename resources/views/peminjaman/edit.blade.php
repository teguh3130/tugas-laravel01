@extends('layouts.app')
@section('title', 'Update Peminjaman')
@section('page-title', 'Update Status Peminjaman')

@section('content')
<div class="max-w-2xl">
    <nav class="flex items-center gap-2 text-sm text-slate-500 mb-5">
        <a href="{{ route('peminjaman.index') }}" class="hover:text-blue-600 transition">Data Peminjaman</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-slate-800 font-medium">Update Status</span>
    </nav>

    <!-- Summary Card -->
    <div class="bg-slate-800 text-white rounded-xl p-5 mb-5">
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Ringkasan Peminjaman</p>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-xs text-slate-400 mb-0.5">Anggota</p>
                <p class="text-sm font-semibold">{{ $peminjaman->anggota->nama }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-400 mb-0.5">Buku</p>
                <p class="text-sm font-semibold truncate">{{ $peminjaman->buku->judul }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-400 mb-0.5">Tanggal Pinjam</p>
                <p class="text-sm font-semibold">{{ $peminjaman->tanggal_pinjam->format('d/m/Y') }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-400 mb-0.5">Status Saat Ini</p>
                @if($peminjaman->status === 'dipinjam')
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-400 text-amber-900">Dipinjam</span>
                @else
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-400 text-emerald-900">Dikembalikan</span>
                @endif
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <h2 class="text-base font-semibold text-slate-800 mb-5">Perbarui Status</h2>

        <form action="{{ route('peminjaman.update', $peminjaman) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Status Peminjaman <span class="text-red-500">*</span></label>
                <div class="flex gap-3">
                    <label class="flex-1 cursor-pointer">
                        <input type="radio" name="status" value="dipinjam" class="sr-only peer"
                               {{ old('status', $peminjaman->status) === 'dipinjam' ? 'checked' : '' }}>
                        <div class="border-2 rounded-lg px-4 py-3 text-center text-sm font-medium transition
                                    border-slate-200 text-slate-600 peer-checked:border-amber-400 peer-checked:bg-amber-50 peer-checked:text-amber-700">
                            <span class="block text-lg mb-1">⏳</span>
                            Dipinjam
                        </div>
                    </label>
                    <label class="flex-1 cursor-pointer">
                        <input type="radio" name="status" value="dikembalikan" class="sr-only peer"
                               {{ old('status', $peminjaman->status) === 'dikembalikan' ? 'checked' : '' }}>
                        <div class="border-2 rounded-lg px-4 py-3 text-center text-sm font-medium transition
                                    border-slate-200 text-slate-600 peer-checked:border-emerald-400 peer-checked:bg-emerald-50 peer-checked:text-emerald-700">
                            <span class="block text-lg mb-1">✅</span>
                            Dikembalikan
                        </div>
                    </label>
                </div>
                @error('status')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <!-- Tanggal Kembali -->
            <div>
                <label for="tanggal_kembali" class="block text-sm font-medium text-slate-700 mb-1.5">
                    Tanggal Kembali
                    <span class="text-xs font-normal text-slate-400">(otomatis diisi saat status dikembalikan)</span>
                </label>
                <input type="date" id="tanggal_kembali" name="tanggal_kembali"
                       value="{{ old('tanggal_kembali', $peminjaman->tanggal_kembali?->format('Y-m-d')) }}"
                       class="w-full px-3.5 py-2.5 text-sm border rounded-lg transition border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                @error('tanggal_kembali')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <!-- Info otomatisasi stok -->
            <div class="bg-amber-50 border border-amber-200 rounded-lg px-4 py-3">
                <p class="text-xs text-amber-700">
                    <strong>⚠️ Perhatian:</strong> Mengubah status ke <em>"Dikembalikan"</em> akan <strong>menambah stok buku otomatis</strong>. Mengubah kembali ke <em>"Dipinjam"</em> akan <strong>mengurangi stok kembali</strong>.
                </p>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Perubahan
                </button>
                <a href="{{ route('peminjaman.index') }}"
                   class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium px-5 py-2.5 rounded-lg transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection