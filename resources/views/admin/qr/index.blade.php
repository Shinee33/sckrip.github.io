@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-[#111827]">QR Code Management</h1>
            <p class="text-xs text-[#6B7280]">Pusat pengelolaan QR Code unik untuk cetak label inventaris dan unduhan format vektor SVG/PNG.</p>
        </div>
    </div>

    <!-- QR Catalog Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($products as $product)
        <div class="rounded-[14px] border border-[#E5E7EB] bg-white p-5 text-center shadow-xs hover:shadow-md transition flex flex-col justify-between">
            <div>
                @php
                    $statusVal = $product->status?->value ?? $product->status;
                    $badgeStyle = match($statusVal) {
                        'active' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                        'damaged' => 'bg-rose-50 text-rose-700 border-rose-200',
                        'borrowed' => 'bg-amber-50 text-amber-700 border-amber-200',
                        'out_of_stock' => 'bg-slate-100 text-slate-700 border-slate-200',
                        default => 'bg-emerald-50 text-emerald-700 border-emerald-200'
                    };
                @endphp
                <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold border {{ $badgeStyle }}">
                    {{ $product->status?->label() }}
                </span>
                <h3 class="mt-2 text-sm font-bold text-[#111827] truncate" title="{{ $product->name }}">{{ $product->name }}</h3>
                <p class="text-xs font-mono font-bold text-[#0F766E] mt-0.5">{{ $product->code }}</p>

                <div class="my-4 p-3 bg-white border border-[#E5E7EB] rounded-xl inline-block shadow-xs">
                    {!! $product->qr_svg !!}
                </div>
                <p class="text-[10px] text-[#6B7280]">Lokasi: {{ $product->location ?? 'Belum diset' }}</p>
            </div>

            <div class="mt-4 pt-3 border-t border-[#E5E7EB] grid grid-cols-2 gap-2">
                <a href="{{ route('admin.qr.download.svg', $product) }}" class="px-2 py-1.5 rounded-xl border border-[#E5E7EB] bg-white text-[11px] font-semibold text-[#111827] hover:bg-gray-50 transition shadow-xs">
                    SVG
                </a>
                <a href="{{ route('admin.qr.print', $product) }}" target="_blank" class="px-2 py-1.5 rounded-xl border border-teal-200 bg-teal-50 text-[11px] font-semibold text-[#0F766E] hover:bg-[#0F766E] hover:text-white transition shadow-xs">
                    Print Label
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-full py-12 text-center text-[#6B7280] bg-white rounded-[14px] border border-[#E5E7EB]">
            Belum ada barang untuk dibuatkan QR Code.
        </div>
        @endforelse
    </div>

    @if($products->hasPages())
    <div class="pt-4">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection
