@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Hero Banner with Fast Search & Scan -->
    <div class="rounded-[14px] border border-[#E5E7EB] bg-white p-6 sm:p-8 shadow-xs relative overflow-hidden">
        <div class="max-w-3xl">
            <span class="text-xs font-bold uppercase tracking-wider text-[#0F766E] bg-teal-50 px-2.5 py-1 rounded-md border border-teal-100">Sistem Informasi & Inventaris Beras (SNI)</span>
            <h1 class="mt-3 text-[32px] font-bold tracking-tight text-[#111827] leading-tight">Cari & Pindai Detail Karakteristik Beras</h1>
            <p class="mt-2 text-base text-[#6B7280]">Gunakan pencarian langsung atau pemindai QR Code kamera HP untuk membaca informasi jenis beras, lokasi tanam, waktu panen, dan spesifikasi mutu SNI secara langsung.</p>

            <!-- Search Bar Form -->
            <form method="GET" action="{{ route('user.products.index') }}" class="mt-5 flex flex-col sm:flex-row gap-2.5">
                <input type="text" name="search" placeholder="Cari nama beras (IR64, Ciherang, Mentik Wangi...), lokasi tanam..."
                    class="w-full h-11 rounded-xl border border-[#E5E7EB] bg-white px-4 text-sm text-[#111827] placeholder-[#6B7280] focus:border-[#0F766E] focus:ring-1 focus:ring-[#0F766E] focus:outline-none shadow-xs transition">
                <button type="submit" class="h-11 rounded-xl bg-[#0F766E] px-6 text-sm font-semibold text-white hover:bg-[#115E59] shadow-xs transition shrink-0 flex items-center justify-center gap-2">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <span>Cari Beras</span>
                </button>
            </form>
        </div>

        <!-- Quick Camera Scan Action -->
        <div class="mt-6 flex flex-wrap items-center gap-4 pt-5 border-t border-[#E5E7EB]">
            <a href="{{ route('user.scan') }}" class="inline-flex items-center gap-2.5 rounded-xl border border-[#0F766E] bg-white px-4 py-2.5 text-xs font-semibold text-[#0F766E] hover:bg-[#0F766E] hover:text-white transition shadow-xs">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                </svg>
                <span>Buka Pemindai Kamera QR</span>
            </a>
            <span class="text-xs text-[#6B7280]">Pindai QR Code kemasan beras untuk melihat sertifikasi SNI & detail varietas.</span>
        </div>
    </div>

    <!-- Jenis Beras Chips -->
    <div>
        <h2 class="text-base font-bold text-[#111827] mb-3">Kategori Jenis Beras</h2>
        <div class="flex flex-wrap gap-2">
            @foreach($categories as $cat)
            <a href="{{ route('user.products.index', ['category_id' => $cat->id]) }}" class="rounded-xl border border-[#E5E7EB] bg-white px-3.5 py-2 text-xs text-[#111827] hover:border-[#0F766E] hover:text-[#0F766E] shadow-xs transition flex items-center">
                <span class="font-medium">{{ $cat->name }}</span>
                <span class="ml-2 rounded-full bg-teal-50 px-2 py-0.5 text-[10px] font-bold text-[#0F766E] border border-teal-100">{{ $cat->products_count }}</span>
            </a>
            @endforeach
        </div>
    </div>

    <!-- Latest Rice Grid -->
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-[#111827]">Daftar Beras Terbaru</h2>
            <a href="{{ route('user.products.index') }}" class="text-xs font-semibold text-[#0F766E] hover:underline">Lihat Semua Beras &rarr;</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($latest_products as $product)
            <div class="rounded-[14px] border border-[#E5E7EB] bg-white p-5 shadow-xs hover:shadow-md transition flex flex-col justify-between">
                <div>
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-44 rounded-xl object-cover border border-[#E5E7EB] mb-3.5" alt="{{ $product->name }}">
                    @else
                        <div class="w-full h-44 rounded-xl bg-teal-50 text-[#0F766E] flex items-center justify-center font-bold text-xl mb-3.5 border border-teal-100">
                            🌾 {{ strtoupper(substr($product->name, 0, 2)) }}
                        </div>
                    @endif

                    <div class="flex items-center justify-between gap-2 mb-1.5">
                        <span class="text-[11px] font-bold text-[#0F766E] bg-teal-50 px-2 py-0.5 rounded border border-teal-100">{!! e($product->category?->name ?? 'Beras') !!}</span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            SNI Mutu
                        </span>
                    </div>

                    <h3 class="text-base font-bold text-[#111827] line-clamp-1">{!! e($product->name) !!}</h3>
                    <p class="text-xs text-[#6B7280] mt-1">Lokasi Tanam: <span class="font-semibold text-[#111827]">{!! e($product->location ?? '-') !!}</span></p>
                    <p class="text-xs text-[#6B7280]">Tanggal Panen: <span class="font-semibold text-[#111827]">{!! e($product->entry_date ? $product->entry_date->format('d/m/Y') : '-') !!}</span></p>
                </div>

                <div class="mt-4 pt-3 border-t border-[#E5E7EB] flex items-center justify-between">
                    <span class="text-xs font-semibold text-[#6B7280]">Masa Simpan: <span class="text-[#0F766E] font-bold">{!! e($product->unit ?? '12 Bulan') !!}</span></span>
                    <a href="{{ route('products.show.public', ['code' => $product->code]) }}" class="px-3.5 py-1.5 rounded-lg bg-[#0F766E] text-xs font-semibold text-white hover:bg-[#115E59] transition shadow-xs">
                        Lihat Detail
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-full py-12 text-center text-[#6B7280] bg-white rounded-[14px] border border-[#E5E7EB]">Belum ada data beras terdaftar.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
