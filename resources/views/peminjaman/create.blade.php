@extends('layouts.app')
@section('title', 'Catat Peminjaman')
@section('page-title', 'Catat Peminjaman Baru')

@section('content')
<div class="max-w-2xl">
    <nav class="flex items-center gap-2 text-sm text-slate-500 mb-5">
        <a href="{{ route('peminjaman.index') }}" class="hover:text-blue-600 transition">Data Peminjaman</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-slate-800 font-medium">Catat Baru</span>
    </nav>

    <!-- Info Banner -->
    <div class="flex items-start gap-3 bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg mb-5">
        <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
        </svg>
        <p class="text-sm">Stok buku akan <strong>otomatis berkurang 1</strong> saat peminjaman berhasil dicatat. Hanya buku dengan stok tersedia yang ditampilkan.</p>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <h2 class="text-base font-semibold text-slate-800 mb-5">Detail Peminjaman</h2>

        <form action="{{ route('peminjaman.store') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Pilih Anggota -->
            <div>
                <label for="anggota_id" class="block text-sm font-medium text-slate-700 mb-1.5">
                    Anggota <span class="text-red-500">*</span>
                </label>
                <select id="anggota_id" name="anggota_id"
                        class="w-full px-3.5 py-2.5 text-sm border rounded-lg transition {{ $errors->has('anggota_id') ? 'border-red-400 bg-red-50' : 'border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100' }}">
                    <option value="">-- Pilih Anggota --</option>
                    @foreach($anggotas as $anggota)
                        <option value="{{ $anggota->id }}" {{ old('anggota_id') == $anggota->id ? 'selected' : '' }}>
                            {{ $anggota->nama }} ({{ $anggota->no_telepon }})
                        </option>
                    @endforeach
                </select>
                @error('anggota_id')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <!-- Pilih Buku -->
            <div>
                <label for="buku_id" class="block text-sm font-medium text-slate-700 mb-1.5">
                    Buku <span class="text-red-500">*</span>
                    <span class="text-xs font-normal text-slate-400">(hanya menampilkan buku dengan stok > 0)</span>
                </label>
                <select id="buku_id" name="buku_id"
                        class="w-full px-3.5 py-2.5 text-sm border rounded-lg transition {{ $errors->has('buku_id') ? 'border-red-400 bg-red-50' : 'border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100' }}">
                    <option value="">-- Pilih Buku --</option>
                    @foreach($bukus as $buku)
                        <option value="{{ $buku->id }}" {{ old('buku_id') == $buku->id ? 'selected' : '' }}>
                            {{ $buku->judul }} — {{ $buku->penulis }} (Stok: {{ $buku->stok }})
                        </option>
                    @endforeach
                </select>
                @error('buku_id')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <!-- Tanggal -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="tanggal_pinjam" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Tanggal Pinjam <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="tanggal_pinjam" name="tanggal_pinjam"
                           value="{{ old('tanggal_pinjam', date('Y-m-d')) }}"
                           max="{{ date('Y-m-d') }}"
                           class="w-full px-3.5 py-2.5 text-sm border rounded-lg transition {{ $errors->has('tanggal_pinjam') ? 'border-red-400 bg-red-50' : 'border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100' }}">
                    @error('tanggal_pinjam')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="tanggal_kembali" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Estimasi Kembali
                        <span class="text-xs font-normal text-slate-400">(opsional)</span>
                    </label>
                    <input type="date" id="tanggal_kembali" name="tanggal_kembali"
                           value="{{ old('tanggal_kembali') }}"
                           class="w-full px-3.5 py-2.5 text-sm border rounded-lg transition {{ $errors->has('tanggal_kembali') ? 'border-red-400 bg-red-50' : 'border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100' }}">
                    @error('tanggal_kembali')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Catat Peminjaman
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