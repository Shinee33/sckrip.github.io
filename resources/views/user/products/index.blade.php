@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-[#111827]">Daftar Inventaris Beras</h1>
        <p class="text-xs text-[#6B7280]">Informasi varietas beras, lokasi tanam, tanggal panen, dan mutu SNI.</p>
    </div>

    <!-- Search & Filters -->
    <div class="rounded-[14px] border border-[#E5E7EB] bg-white p-4 shadow-xs">
        <form method="GET" action="{{ route('user.products.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <div class="lg:col-span-2">
                <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Cari nama beras, lokasi tanam, varietas..."
                    class="w-full h-10 rounded-xl border border-[#E5E7EB] bg-white px-3.5 text-xs text-[#111827] placeholder-[#6B7280] focus:border-[#0F766E] focus:ring-1 focus:ring-[#0F766E] focus:outline-none transition">
            </div>
            <div>
                <select name="category_id" class="w-full h-10 rounded-xl border border-[#E5E7EB] bg-white px-3 text-xs text-[#111827] focus:border-[#0F766E] focus:ring-1 focus:ring-[#0F766E] focus:outline-none transition">
                    <option value="">-- Semua Jenis Beras --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ ($filters['category_id'] ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-center gap-2">
                <button type="submit" class="w-full h-10 rounded-xl bg-[#0F766E] py-2 text-xs font-semibold text-white hover:bg-[#115E59] transition shadow-xs">Cari</button>
                <a href="{{ route('user.products.index') }}" class="h-10 rounded-xl border border-[#E5E7EB] px-3.5 py-2 text-xs text-[#6B7280] hover:text-[#111827] hover:bg-gray-50 flex items-center justify-center">Reset</a>
            </div>
        </form>
    </div>

    <!-- Rice Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($products as $product)
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
                <p class="text-xs text-[#6B7280]">Waktu Panen: <span class="font-semibold text-[#111827]">{!! e($product->entry_date ? $product->entry_date->format('d/m/Y') : '-') !!}</span></p>
            </div>

            <div class="mt-4 pt-3 border-t border-[#E5E7EB] flex items-center justify-between">
                <span class="text-xs font-semibold text-[#6B7280]">Masa Simpan: <span class="text-[#0F766E] font-bold">{!! e($product->unit ?? '12 Bulan') !!}</span></span>
                <a href="{{ route('products.show.public', ['code' => $product->code]) }}" class="px-3.5 py-1.5 rounded-lg bg-[#0F766E] text-xs font-semibold text-white hover:bg-[#115E59] transition shadow-xs">
                    Lihat Detail
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-full py-12 text-center text-[#6B7280] bg-white rounded-[14px] border border-[#E5E7EB]">Tidak ada data beras yang ditemukan.</div>
        @endforelse
    </div>

    @if($products->hasPages())
    <div class="pt-4">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection
