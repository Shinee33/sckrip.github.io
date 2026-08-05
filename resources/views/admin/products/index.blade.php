@extends('layouts.app')

@section('content')
<div class="space-y-6" x-data="{ showDeleteModal: false, deleteActionUrl: '', deleteItemName: '' }">
    <!-- Top Action Header -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-[#111827]">Kelola Data Beras</h1>
            <p class="text-xs text-[#6B7280]">Kelola data inventaris beras, lokasi tanam, waktu panen, serta karakteristik SNI.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.products.index', ['trashed' => $showTrashed ? 0 : 1]) }}" class="inline-flex items-center gap-2 rounded-xl border border-[#E5E7EB] px-3.5 py-2 text-xs font-semibold {{ $showTrashed ? 'bg-rose-50 text-rose-700 border-rose-200' : 'bg-white text-[#111827] hover:bg-gray-50' }} shadow-xs">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                <span>{{ $showTrashed ? 'Kembali ke Data Beras Aktif' : 'Riwayat Dihapus' }}</span>
            </a>
            <a href="{{ route('admin.products.export') }}" class="inline-flex items-center gap-2 rounded-xl border border-[#E5E7EB] bg-white px-3.5 py-2 text-xs font-semibold text-[#111827] hover:bg-gray-50 shadow-xs">
                Export Data CSV
            </a>
            <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-[#0F766E] px-4 py-2 text-xs font-semibold text-white hover:bg-[#115E59] shadow-xs transition">
                + Tambah Data Beras
            </a>
        </div>
    </div>

    <!-- Filters & Search Bar Card -->
    <div class="rounded-[14px] border border-[#E5E7EB] bg-white p-4 shadow-xs">
        <form method="GET" action="{{ route('admin.products.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            @if($showTrashed)
                <input type="hidden" name="trashed" value="1">
            @endif

            <!-- Search Field -->
            <div class="lg:col-span-2">
                <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Cari nama beras, lokasi tanam, varietas, karakteristik SNI..."
                    class="w-full h-10 rounded-xl border border-[#E5E7EB] bg-white px-3.5 text-xs text-[#111827] placeholder-[#6B7280] focus:border-[#0F766E] focus:ring-1 focus:ring-[#0F766E] focus:outline-none">
            </div>

            <!-- Category / Jenis Beras Filter -->
            <div>
                <select name="category_id" class="w-full h-10 rounded-xl border border-[#E5E7EB] bg-white px-3 text-xs text-[#111827] focus:border-[#0F766E] focus:ring-1 focus:ring-[#0F766E] focus:outline-none">
                    <option value="">-- Semua Jenis Beras --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ ($filters['category_id'] ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Buttons -->
            <div class="flex items-center gap-2">
                <button type="submit" class="w-full h-10 rounded-xl bg-[#0F766E] py-2 text-xs font-semibold text-white hover:bg-[#115E59] transition shadow-xs">Cari</button>
                <a href="{{ route('admin.products.index') }}" class="h-10 rounded-xl border border-[#E5E7EB] px-3.5 py-2 text-xs text-[#6B7280] hover:text-[#111827] hover:bg-gray-50 flex items-center justify-center">Reset</a>
            </div>
        </form>
    </div>

    <!-- Product Table -->
    <div class="overflow-hidden rounded-[14px] border border-[#E5E7EB] bg-white shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-[#F8FAFC] text-[#6B7280] uppercase tracking-wider font-bold border-b border-[#E5E7EB]">
                    <tr>
                        <th class="px-5 py-4">Nama Beras</th>
                        <th class="px-4 py-4">Jenis Beras</th>
                        <th class="px-4 py-4">Lokasi Tanam</th>
                        <th class="px-4 py-4">Tanggal Panen</th>
                        <th class="px-4 py-4">Masa Simpan</th>
                        <th class="px-5 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E5E7EB]">
                    @forelse($products as $p)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                @if($p->image)
                                    <img src="{{ asset('storage/' . $p->image) }}" class="h-10 w-10 rounded-xl object-cover border border-[#E5E7EB]" alt="{{ $p->name }}">
                                @else
                                    <div class="h-10 w-10 rounded-xl bg-teal-50 text-[#0F766E] flex items-center justify-center font-bold text-xs border border-teal-100">
                                        {{ strtoupper(substr($p->name, 0, 2)) }}
                                    </div>
                                @endif
                                <div>
                                    <a href="{{ route('admin.products.show', $p) }}" class="font-bold text-[#111827] hover:text-[#0F766E] transition text-sm">
                                        {{ $p->name }}
                                    </a>
                                    <div class="text-[11px] text-[#6B7280] truncate max-w-xs">{{ Str::limit($p->description, 45) }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4 font-bold text-[#0F766E]">
                            {{ $p->category?->name ?? 'Beras' }}
                        </td>
                        <td class="px-4 py-4 text-[#111827] font-medium">
                            {{ $p->location ?? '-' }}
                        </td>
                        <td class="px-4 py-4 text-[#6B7280] font-medium">
                            {{ $p->entry_date ? $p->entry_date->format('d/m/Y') : '-' }}
                        </td>
                        <td class="px-4 py-4 font-semibold text-[#111827]">
                            {{ $p->unit ?? '12 Bulan' }}
                        </td>
                        <td class="px-5 py-4 text-right space-x-1.5">
                            @if($showTrashed)
                                <form method="POST" action="{{ route('admin.products.restore', $p->id) }}" class="inline-block">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 rounded-lg bg-teal-50 text-[#0F766E] border border-teal-200 text-[11px] font-semibold hover:bg-[#0F766E] hover:text-white transition shadow-xs">
                                        Pulihkan
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('admin.products.show', $p) }}" class="px-2.5 py-1 rounded-lg bg-white border border-[#E5E7EB] text-[#111827] text-[11px] font-semibold hover:bg-gray-50 transition shadow-xs">
                                    Detail & QR
                                </a>
                                <a href="{{ route('admin.products.edit', $p) }}" class="px-2.5 py-1 rounded-lg bg-teal-50 text-[#0F766E] border border-teal-200 text-[11px] font-semibold hover:bg-[#0F766E] hover:text-white transition shadow-xs">
                                    Edit
                                </a>
                                <button type="button" 
                                    @click="showDeleteModal = true; deleteActionUrl = '{{ route('admin.products.destroy', $p) }}'; deleteItemName = '{{ addslashes($p->name) }}'"
                                    class="px-2.5 py-1 rounded-lg bg-rose-50 text-rose-700 border border-rose-200 text-[11px] font-semibold hover:bg-rose-600 hover:text-white transition shadow-xs">
                                    Hapus
                                </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center text-[#6B7280]">
                            <svg class="h-10 w-10 mx-auto text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            Belum ada data beras yang terdaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($products->hasPages())
        <div class="p-4 border-t border-[#E5E7EB]">
            {{ $products->links() }}
        </div>
        @endif
    </div>

    <!-- Modern Custom Alpine.js Delete Confirmation Modal -->
    <div x-show="showDeleteModal" x-cloak 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-xs">
        
        <div @click.away="showDeleteModal = false" 
             x-show="showDeleteModal"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95 translate-y-2"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-2"
             class="w-full max-w-md rounded-[16px] border border-[#E5E7EB] bg-white p-6 shadow-xl">
            
            <div class="flex items-start gap-4">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-rose-50 text-rose-600 border border-rose-100">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-[#111827]">Hapus Data Beras</h3>
                    <p class="mt-1 text-xs text-[#6B7280] leading-relaxed">
                        Apakah Anda yakin ingin menghapus data beras <strong class="text-[#111827]" x-text="deleteItemName"></strong>?
                    </p>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-3 border-t border-gray-100 pt-4">
                <button type="button" 
                        @click="showDeleteModal = false" 
                        class="rounded-xl border border-[#E5E7EB] bg-white px-4 py-2 text-xs font-semibold text-[#111827] hover:bg-gray-50 transition shadow-xs">
                    Batal
                </button>
                <form :action="deleteActionUrl" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="rounded-xl bg-rose-600 px-4 py-2 text-xs font-semibold text-white hover:bg-rose-700 transition shadow-xs">
                        Ya, Hapus Data
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
