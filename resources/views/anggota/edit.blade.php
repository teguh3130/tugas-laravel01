@extends('layouts.app')
@section('title', 'Edit Anggota')
@section('page-title', 'Edit Data Anggota')

@section('content')
<div class="max-w-2xl">
    <nav class="flex items-center gap-2 text-sm text-slate-500 mb-5">
        <a href="{{ route('anggota.index') }}" class="hover:text-blue-600 transition">Manajemen Anggota</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-slate-800 font-medium">Edit Anggota</span>
    </nav>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <h2 class="text-base font-semibold text-slate-800 mb-5">Edit Data Anggota</h2>

        <form action="{{ route('anggota.update', $anggota) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="nama" class="block text-sm font-medium text-slate-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" id="nama" name="nama" value="{{ old('nama', $anggota->nama) }}"
                       class="w-full px-3.5 py-2.5 text-sm border rounded-lg transition {{ $errors->has('nama') ? 'border-red-400 bg-red-50' : 'border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100' }}">
                @error('nama')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="no_telepon" class="block text-sm font-medium text-slate-700 mb-1.5">Nomor Telepon <span class="text-red-500">*</span></label>
                <input type="text" id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $anggota->no_telepon) }}"
                       class="w-full px-3.5 py-2.5 text-sm border rounded-lg transition {{ $errors->has('no_telepon') ? 'border-red-400 bg-red-50' : 'border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100' }}">
                @error('no_telepon')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="alamat" class="block text-sm font-medium text-slate-700 mb-1.5">Alamat <span class="text-red-500">*</span></label>
                <textarea id="alamat" name="alamat" rows="3"
                          class="w-full px-3.5 py-2.5 text-sm border rounded-lg transition resize-none border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">{{ old('alamat', $anggota->alamat) }}</textarea>
                @error('alamat')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Perbarui Anggota
                </button>
                <a href="{{ route('anggota.index') }}"
                   class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium px-5 py-2.5 rounded-lg transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection