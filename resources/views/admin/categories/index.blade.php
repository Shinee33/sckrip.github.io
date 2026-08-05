@extends('layouts.app')

@section('content')
<div class="space-y-6" x-data="{ createModal: false, editModal: false, deleteModal: false, activeCat: {}, deleteUrl: '', deleteName: '' }">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-[#111827]">Kelola Jenis Beras</h1>
            <p class="text-xs text-[#6B7280]">Tambah, ubah, dan hapus kategori jenis beras untuk pengelompokan inventaris.</p>
        </div>
        <button @click="createModal = true" class="inline-flex items-center gap-2 rounded-xl bg-[#0F766E] px-4 py-2 text-xs font-semibold text-white hover:bg-[#115E59] shadow-xs transition">
            + Tambah Jenis Beras
        </button>
    </div>

    <!-- Table -->
    <div class="overflow-hidden rounded-[14px] border border-[#E5E7EB] bg-white shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-[#F8FAFC] text-[#6B7280] uppercase tracking-wider font-bold border-b border-[#E5E7EB]">
                    <tr>
                        <th class="px-5 py-4">Jenis Beras</th>
                        <th class="px-4 py-4">Slug</th>
                        <th class="px-4 py-4">Deskripsi</th>
                        <th class="px-4 py-4">Jumlah Terdaftar</th>
                        <th class="px-5 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E5E7EB]">
                    @forelse($categories as $cat)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-4 font-bold text-[#111827] text-sm">{{ $cat->name }}</td>
                        <td class="px-4 py-4 text-[#6B7280] font-mono">{{ $cat->slug }}</td>
                        <td class="px-4 py-4 text-[#6B7280]">{{ $cat->description ?? '-' }}</td>
                        <td class="px-4 py-4 font-bold text-[#0F766E]">{{ $cat->products_count }} data beras</td>
                        <td class="px-5 py-4 text-right space-x-1.5">
                            <button @click="editModal = true; activeCat = { id: {{ $cat->id }}, name: '{{ addslashes($cat->name) }}', description: '{{ addslashes($cat->description ?? '') }}' }"
                                class="px-3 py-1 rounded-lg bg-teal-50 text-[#0F766E] border border-teal-200 text-[11px] font-semibold hover:bg-[#0F766E] hover:text-white transition shadow-xs">
                                Edit
                            </button>
                            <button type="button" 
                                @click="deleteModal = true; deleteUrl = '/admin/categories/{{ $cat->id }}'; deleteName = '{{ addslashes($cat->name) }}'"
                                class="px-3 py-1 rounded-lg bg-rose-50 text-rose-700 border border-rose-200 text-[11px] font-semibold hover:bg-rose-600 hover:text-white transition shadow-xs">
                                Hapus
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-10 text-center text-[#6B7280]">Belum ada jenis beras terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Create -->
    <div x-show="createModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-xs">
        <div @click.away="createModal = false" class="w-full max-w-md rounded-[16px] border border-[#E5E7EB] bg-white p-6 shadow-xl space-y-4">
            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <h3 class="text-base font-bold text-[#111827]">Tambah Jenis Beras Baru</h3>
                <button type="button" @click="createModal = false" class="text-gray-400 hover:text-gray-600">✕</button>
            </div>
            <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-[#111827]">Nama Jenis Beras <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" required placeholder="Contoh: Beras Pandan Wangi" class="mt-1.5 w-full h-10 rounded-xl border border-[#E5E7EB] bg-white px-4 text-xs text-[#111827] focus:border-[#0F766E] focus:ring-1 focus:ring-[#0F766E] focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-[#111827]">Deskripsi (Opsional)</label>
                    <textarea name="description" rows="3" placeholder="Keterangan jenis beras..." class="mt-1.5 w-full rounded-xl border border-[#E5E7EB] bg-white p-3 text-xs text-[#111827] focus:border-[#0F766E] focus:ring-1 focus:ring-[#0F766E] focus:outline-none"></textarea>
                </div>
                <div class="flex justify-end gap-2 pt-3 border-t border-[#E5E7EB]">
                    <button type="button" @click="createModal = false" class="px-4 py-2 rounded-xl text-xs font-semibold border border-[#E5E7EB] bg-white text-[#111827]">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-[#0F766E] text-xs font-semibold text-white hover:bg-[#115E59]">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit -->
    <div x-show="editModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-xs">
        <div @click.away="editModal = false" class="w-full max-w-md rounded-[16px] border border-[#E5E7EB] bg-white p-6 shadow-xl space-y-4">
            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <h3 class="text-base font-bold text-[#111827]">Edit Jenis Beras</h3>
                <button type="button" @click="editModal = false" class="text-gray-400 hover:text-gray-600">✕</button>
            </div>
            <form :action="'/admin/categories/' + activeCat.id" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-semibold text-[#111827]">Nama Jenis Beras <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" x-model="activeCat.name" required class="mt-1.5 w-full h-10 rounded-xl border border-[#E5E7EB] bg-white px-4 text-xs text-[#111827] focus:border-[#0F766E] focus:ring-1 focus:ring-[#0F766E] focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-[#111827]">Deskripsi</label>
                    <textarea name="description" rows="3" x-model="activeCat.description" class="mt-1.5 w-full rounded-xl border border-[#E5E7EB] bg-white p-3 text-xs text-[#111827] focus:border-[#0F766E] focus:ring-1 focus:ring-[#0F766E] focus:outline-none"></textarea>
                </div>
                <div class="flex justify-end gap-2 pt-3 border-t border-[#E5E7EB]">
                    <button type="button" @click="editModal = false" class="px-4 py-2 rounded-xl text-xs font-semibold border border-[#E5E7EB] bg-white text-[#111827]">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-[#0F766E] text-xs font-semibold text-white hover:bg-[#115E59]">Perbarui</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Custom Delete Modal -->
    <div x-show="deleteModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-xs">
        <div @click.away="deleteModal = false" class="w-full max-w-md rounded-[16px] border border-[#E5E7EB] bg-white p-6 shadow-xl space-y-4">
            <div class="flex items-start gap-4">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-rose-50 text-rose-600 border border-rose-100">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-[#111827]">Hapus Jenis Beras</h3>
                    <p class="mt-1 text-xs text-[#6B7280] leading-relaxed">
                        Apakah Anda yakin ingin menghapus jenis beras <strong class="text-[#111827]" x-text="deleteName"></strong>?
                    </p>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-3 border-t border-gray-100">
                <button type="button" @click="deleteModal = false" class="rounded-xl border border-[#E5E7EB] bg-white px-4 py-2 text-xs font-semibold text-[#111827]">Batal</button>
                <form :action="deleteUrl" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="rounded-xl bg-rose-600 px-4 py-2 text-xs font-semibold text-white hover:bg-rose-700">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
