@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header Back Navigation -->
    <div class="flex items-center justify-between">
        <a href="{{ route('user.products.index') }}" class="inline-flex items-center gap-1.5 rounded-xl border border-[#E5E7EB] bg-white px-3.5 py-2 text-xs font-semibold text-[#111827] hover:bg-gray-50 transition shadow-xs">
            <svg class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Daftar Beras
        </a>
        <span class="inline-flex items-center gap-1.5 rounded-md bg-teal-50 px-2.5 py-1 text-xs font-bold uppercase tracking-wider text-[#0F766E] border border-teal-200">
            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Informasi Karakteristik Beras (SNI)
        </span>
    </div>

    <!-- Read-Only Rice Information Card -->
    <div class="rounded-[14px] border border-[#E5E7EB] bg-white p-6 sm:p-8 shadow-xs space-y-8">
        
        <!-- Header Banner -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-100 pb-6">
            <div>
                <span class="text-xs font-semibold text-[#0F766E] uppercase tracking-wider">{{ $product->category?->name ?? 'Beras' }}</span>
                <h1 class="text-3xl font-extrabold text-[#111827] mt-1">{{ $product->name }}</h1>
                <p class="text-xs text-[#6B7280] mt-1 flex items-center gap-2">
                    <svg class="h-4 w-4 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>Lokasi Tanam: <strong>{{ $product->location ?? 'Tidak ditentukan' }}</strong></span>
                </p>
            </div>
            
            @if ($product->image)
                <div class="shrink-0">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-24 w-24 rounded-xl object-cover border border-[#E5E7EB] shadow-xs">
                </div>
            @endif
        </div>

        <!-- 7 Key Required Rice Data Fields -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- 1. Nama Beras -->
            <div class="rounded-xl border border-gray-100 bg-[#F8FAFC] p-4">
                <div class="text-[11px] font-semibold uppercase text-[#6B7280] tracking-wider">1. Nama Beras</div>
                <div class="text-base font-bold text-[#111827] mt-1">{{ $product->name }}</div>
            </div>

            <!-- 3. Jenis Beras -->
            <div class="rounded-xl border border-gray-100 bg-[#F8FAFC] p-4">
                <div class="text-[11px] font-semibold uppercase text-[#6B7280] tracking-wider">3. Jenis Beras</div>
                <div class="text-base font-bold text-[#0F766E] mt-1">{{ $product->category?->name ?? 'Beras Standar' }}</div>
            </div>

            <!-- 4. Lokasi Tanam -->
            <div class="rounded-xl border border-gray-100 bg-[#F8FAFC] p-4">
                <div class="text-[11px] font-semibold uppercase text-[#6B7280] tracking-wider">4. Lokasi Tanam</div>
                <div class="text-base font-semibold text-[#111827] mt-1 flex items-center gap-1.5">
                    <svg class="h-4 w-4 text-[#0F766E]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    </svg>
                    {{ $product->location ?? '-' }}
                </div>
            </div>

            <!-- 5. Waktu & Tanggal Panen -->
            <div class="rounded-xl border border-gray-100 bg-[#F8FAFC] p-4">
                <div class="text-[11px] font-semibold uppercase text-[#6B7280] tracking-wider">5. Waktu & Tanggal Panen</div>
                <div class="text-base font-semibold text-[#111827] mt-1 flex items-center gap-1.5">
                    <svg class="h-4 w-4 text-[#0F766E]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    {{ $product->entry_date ? $product->entry_date->format('d F Y') : '-' }}
                </div>
            </div>

            <!-- 7. Estimasi Masa Simpan -->
            <div class="rounded-xl border border-gray-100 bg-[#F8FAFC] p-4">
                <div class="text-[11px] font-semibold uppercase text-[#6B7280] tracking-wider">7. Estimasi Masa Simpan</div>
                <div class="text-base font-bold text-[#111827] mt-1">{{ $product->unit ?? '12 Bulan' }}</div>
                @if ($product->brand)
                    <div class="text-xs text-[#6B7280] mt-1">Catatan: {{ $product->brand }}</div>
                @endif
            </div>

            <!-- Standar Sertifikasi -->
            <div class="rounded-xl border border-emerald-100 bg-emerald-50/50 p-4">
                <div class="text-[11px] font-semibold uppercase text-emerald-800 tracking-wider">Sertifikasi & Mutu</div>
                <div class="text-xs font-semibold text-emerald-900 mt-1 flex items-center gap-1.5">
                    <svg class="h-4 w-4 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <span>{{ $product->serial_number ?: 'Memenuhi Standar Mutu SNI Beras' }}</span>
                </div>
            </div>
        </div>

        <!-- 2. Penjelasan Mengenai Beras -->
        <div class="space-y-2">
            <h3 class="text-xs font-bold uppercase text-[#111827] tracking-wider">2. Penjelasan Mengenai Beras</h3>
            <div class="rounded-xl border border-[#E5E7EB] bg-[#F8FAFC] p-4 text-xs leading-relaxed text-[#374151]">
                {!! nl2br(e($product->description ?? 'Belum ada penjelasan deskripsi.')) !!}
            </div>
        </div>

        <!-- 6. Karakteristik (SNI) -->
        <div class="space-y-2">
            <h3 class="text-xs font-bold uppercase text-[#111827] tracking-wider flex items-center gap-2">
                <svg class="h-4 w-4 text-[#0F766E]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                6. Karakteristik Mutu (SNI)
            </h3>
            <div class="rounded-xl border border-[#E5E7EB] bg-white p-5 font-mono text-xs leading-relaxed text-[#111827] shadow-2xs">
                {!! nl2br(e($product->specifications ?? "Kadar Air: Max 14%\nButir Kepala: Min 85%\nButir Patah: Max 15%\nDerajat Sosoh: Min 95%\nStandar Mutu: SNI 6128:2020")) !!}
            </div>
        </div>
    </div>
</div>
@endsection
