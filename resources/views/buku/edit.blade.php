@extends('layouts.app')
@section('title', 'Edit Buku')
@section('page-title', 'Edit Data Buku')

@section('content')
<div class="max-w-2xl">
    <nav class="flex items-center gap-2 text-sm text-slate-500 mb-5">
        <a href="{{ route('buku.index') }}" class="hover:text-blue-600 transition">Manajemen Buku</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-slate-800 font-medium">Edit Buku</span>
    </nav>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <h2 class="text-base font-semibold text-slate-800 mb-5">Edit Informasi Buku</h2>

        <form action="{{ route('buku.update', $buku) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="judul" class="block text-sm font-medium text-slate-700 mb-1.5">Judul Buku <span class="text-red-500">*</span></label>
                <input type="text" id="judul" name="judul" value="{{ old('judul', $buku->judul) }}"
                       class="w-full px-3.5 py-2.5 text-sm border rounded-lg transition {{ $errors->has('judul') ? 'border-red-400 bg-red-50' : 'border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100' }}">
                @error('judul')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="penulis" class="block text-sm font-medium text-slate-700 mb-1.5">Penulis <span class="text-red-500">*</span></label>
                    <input type="text" id="penulis" name="penulis" value="{{ old('penulis', $buku->penulis) }}"
                           class="w-full px-3.5 py-2.5 text-sm border rounded-lg transition border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                    @error('penulis')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="penerbit" class="block text-sm font-medium text-slate-700 mb-1.5">Penerbit <span class="text-red-500">*</span></label>
                    <input type="text" id="penerbit" name="penerbit" value="{{ old('penerbit', $buku->penerbit) }}"
                           class="w-full px-3.5 py-2.5 text-sm border rounded-lg transition border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                    @error('penerbit')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="tahun_terbit" class="block text-sm font-medium text-slate-700 mb-1.5">Tahun Terbit <span class="text-red-500">*</span></label>
                    <input type="number" id="tahun_terbit" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}"
                           min="1900" max="{{ date('Y') }}"
                           class="w-full px-3.5 py-2.5 text-sm border rounded-lg transition border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                    @error('tahun_terbit')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="stok" class="block text-sm font-medium text-slate-700 mb-1.5">Stok <span class="text-red-500">*</span></label>
                    <input type="number" id="stok" name="stok" value="{{ old('stok', $buku->stok) }}" min="0"
                           class="w-full px-3.5 py-2.5 text-sm border rounded-lg transition border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                    @error('stok')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Perbarui Buku
                </button>
                <a href="{{ route('buku.index') }}"
                   class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium px-5 py-2.5 rounded-lg transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection