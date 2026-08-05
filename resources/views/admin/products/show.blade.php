@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <!-- Top Action Toolbar -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider bg-teal-50 text-[#0F766E] border border-teal-200">
                    {{ $product->category?->name ?? 'Beras' }}
                </span>
                <span class="text-xs text-[#6B7280] font-mono">ID / Kode: {{ $product->code }}</span>
            </div>
            <h1 class="mt-1 text-3xl font-bold text-[#111827]">{{ $product->name }}</h1>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.qr.download.svg', $product) }}" class="px-3.5 py-2 rounded-xl border border-[#E5E7EB] bg-white text-xs font-semibold text-[#111827] hover:bg-gray-50 shadow-xs transition">
                Download SVG
            </a>
            <a href="{{ route('admin.qr.download.png', $product) }}" class="px-3.5 py-2 rounded-xl border border-[#E5E7EB] bg-white text-xs font-semibold text-[#111827] hover:bg-gray-50 shadow-xs transition">
                Download PNG
            </a>
            <a href="{{ route('admin.qr.print', $product) }}" target="_blank" class="px-3.5 py-2 rounded-xl border border-teal-200 bg-teal-50 text-xs font-semibold text-[#0F766E] hover:bg-[#0F766E] hover:text-white shadow-xs transition">
                🖨️ Cetak QR Label
            </a>
            <a href="{{ route('admin.products.edit', $product) }}" class="px-4 py-2 rounded-xl bg-[#0F766E] text-xs font-semibold text-white hover:bg-[#115E59] shadow-xs transition flex items-center gap-1.5">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Data Beras
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left 2 Columns: Product Information Details -->
        <div class="lg:col-span-2 space-y-6">
            <div class="rounded-[14px] border border-[#E5E7EB] bg-white p-6 shadow-xs space-y-6">
                <h2 class="text-base font-bold text-[#111827] border-b border-[#E5E7EB] pb-3">Informasi Karakteristik Beras</h2>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <span class="text-[#6B7280] uppercase tracking-wider text-[10px] block font-semibold">1. Nama Beras</span>
                        <span class="text-[#111827] text-sm font-bold">{!! e($product->name) !!}</span>
                    </div>

                    <div>
                        <span class="text-[#6B7280] uppercase tracking-wider text-[10px] block font-semibold">3. Jenis Beras</span>
                        <span class="text-[#0F766E] font-bold text-sm">{!! e($product->category?->name ?? 'Beras') !!}</span>
                    </div>

                    <div>
                        <span class="text-[#6B7280] uppercase tracking-wider text-[10px] block font-semibold">4. Lokasi Tanam</span>
                        <span class="text-[#111827] font-medium">{!! e($product->location ?? '-') !!}</span>
                    </div>

                    <div>
                        <span class="text-[#6B7280] uppercase tracking-wider text-[10px] block font-semibold">5. Waktu & Tanggal Panen</span>
                        <span class="text-[#111827] font-medium">{!! e($product->entry_date?->format('d F Y') ?? '-') !!}</span>
                    </div>

                    <div>
                        <span class="text-[#6B7280] uppercase tracking-wider text-[10px] block font-semibold">7. Estimasi Masa Simpan</span>
                        <span class="text-[#111827] font-bold text-sm">{!! e($product->unit ?? '12 Bulan') !!}</span>
                    </div>

                    <div>
                        <span class="text-[#6B7280] uppercase tracking-wider text-[10px] block font-semibold">Sertifikasi & Mutu</span>
                        <span class="text-[#0F766E] font-semibold">{!! e($product->serial_number ?: 'Memenuhi Standar Mutu SNI Beras') !!}</span>
                    </div>

                    <div>
                        <span class="text-[#6B7280] uppercase tracking-wider text-[10px] block font-semibold">Catatan Penyimpanan</span>
                        <span class="text-[#111827] font-medium">{!! e($product->brand ?? '-') !!}</span>
                    </div>
                </div>

                <!-- Penjelasan -->
                <div class="pt-4 border-t border-[#E5E7EB]">
                    <span class="text-[#6B7280] uppercase tracking-wider text-[10px] block font-semibold mb-1">2. Penjelasan Mengenai Beras</span>
                    <div class="rounded-xl border border-[#E5E7EB] bg-[#F8FAFC] p-4 text-xs text-[#111827] whitespace-pre-line leading-relaxed">
                        {!! e($product->description ?? 'Tidak ada penjelasan deskripsi.') !!}
                    </div>
                </div>

                <!-- Karakteristik SNI -->
                <div>
                    <span class="text-[#6B7280] uppercase tracking-wider text-[10px] block font-semibold mb-1">6. Karakteristik Mutu (SNI)</span>
                    <div class="rounded-xl border border-[#E5E7EB] bg-white p-4 font-mono text-xs text-[#111827] whitespace-pre-line leading-relaxed shadow-2xs">
                        {!! e($product->specifications ?? 'Kadar air, butir kepala, butir patah, derajat sosoh, standar mutu SNI.') !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- Right 1 Column: Product Image & QR Code Card -->
        <div class="space-y-6">
            <!-- QR Code Card -->
            <div class="rounded-[14px] border border-[#E5E7EB] bg-white p-6 text-center shadow-xs">
                <span class="text-xs font-bold uppercase tracking-wider text-[#0F766E]">QR Code Publik Beras</span>
                <p class="text-[11px] text-[#6B7280] mt-1 mb-4">Scan QR code untuk membuka halaman detail beras publik</p>
                
                <div class="my-4 p-3 bg-white border border-[#E5E7EB] rounded-xl inline-block shadow-xs">
                    {!! $qrCodeSvg !!}
                </div>

                <p class="text-[10px] font-mono text-[#6B7280] truncate">{{ route('products.show.public', ['code' => $product->code]) }}</p>

                <form method="POST" action="{{ route('admin.qr.regenerate', $product) }}" class="mt-4">
                    @csrf
                    <button type="submit" class="w-full py-2 rounded-xl border border-[#E5E7EB] bg-[#F8FAFC] text-xs font-semibold text-[#111827] hover:bg-gray-100 transition shadow-xs">
                        🔄 Regenerate QR Code
                    </button>
                </form>
            </div>

            <!-- Foto Beras -->
            @if($product->image)
            <div class="rounded-[14px] border border-[#E5E7EB] bg-white p-6 shadow-xs">
                <span class="text-xs font-bold uppercase tracking-wider text-[#6B7280] block mb-3">Foto Beras</span>
                <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-56 rounded-xl object-cover border border-[#E5E7EB]" alt="{{ $product->name }}">
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
