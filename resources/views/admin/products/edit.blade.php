@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6" x-data="editProductForm()">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-[#111827]">Edit Data Beras: {{ $product->name }}</h1>
            <p class="text-xs text-[#6B7280]">Perbarui informasi karakteristik beras dan standar SNI</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="inline-flex items-center gap-1.5 rounded-xl border border-[#E5E7EB] bg-white px-3.5 py-2 text-xs font-semibold text-[#111827] hover:bg-gray-50 transition shadow-xs">
            <svg class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="rounded-xl border border-rose-200 bg-rose-50 p-4 text-xs text-rose-800">
            <div class="font-bold mb-1">Terjadi kesalahan input:</div>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="rounded-[14px] border border-[#E5E7EB] bg-white p-6 shadow-xs space-y-6">
            <h2 class="text-sm font-bold text-[#111827] border-b border-gray-100 pb-3 flex items-center gap-2">
                <svg class="h-4 w-4 text-[#0F766E]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Informasi Utama Beras
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- 1. Nama Beras -->
                <div>
                    <label class="block text-xs font-semibold text-[#111827] mb-1.5">1. Nama Beras <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full rounded-xl border border-[#E5E7EB] px-3.5 py-2.5 text-xs text-[#111827] focus:border-[#0F766E] focus:outline-none focus:ring-1 focus:ring-[#0F766E] transition">
                </div>

                <!-- 3. Jenis Beras (Dropdown) -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-xs font-semibold text-[#111827]">3. Jenis Beras <span class="text-rose-500">*</span></label>
                        <button type="button" @click="showCategoryModal = true" class="text-[11px] font-bold text-[#0F766E] hover:underline flex items-center gap-1">
                            ⚙️ Kelola / Tambah Jenis Beras
                        </button>
                    </div>
                    <select name="category_id" id="category_select" required class="w-full rounded-xl border border-[#E5E7EB] px-3.5 py-2.5 text-xs text-[#111827] focus:border-[#0F766E] focus:outline-none focus:ring-1 focus:ring-[#0F766E] transition">
                        <option value="">-- Pilih Jenis Beras --</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- 2. Penjelasan Mengenai Beras -->
            <div>
                <label class="block text-xs font-semibold text-[#111827] mb-1.5">2. Penjelasan Mengenai Beras <span class="text-rose-500">*</span></label>
                <textarea name="description" rows="4" required class="w-full rounded-xl border border-[#E5E7EB] px-3.5 py-2.5 text-xs text-[#111827] focus:border-[#0F766E] focus:outline-none focus:ring-1 focus:ring-[#0F766E] transition">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- 4. Lokasi Tanam -->
                <div>
                    <label class="block text-xs font-semibold text-[#111827] mb-1.5">4. Lokasi Tanam <span class="text-rose-500">*</span></label>
                    <input type="text" name="location" value="{{ old('location', $product->location) }}" required class="w-full rounded-xl border border-[#E5E7EB] px-3.5 py-2.5 text-xs text-[#111827] focus:border-[#0F766E] focus:outline-none focus:ring-1 focus:ring-[#0F766E] transition">
                </div>

                <!-- 5. Waktu & Tanggal Panen -->
                <div>
                    <label class="block text-xs font-semibold text-[#111827] mb-1.5">5. Waktu & Tanggal Panen <span class="text-rose-500">*</span></label>
                    <input type="date" name="entry_date" value="{{ old('entry_date', $product->entry_date ? $product->entry_date->format('Y-m-d') : date('Y-m-d')) }}" required class="w-full rounded-xl border border-[#E5E7EB] px-3.5 py-2.5 text-xs text-[#111827] focus:border-[#0F766E] focus:outline-none focus:ring-1 focus:ring-[#0F766E] transition">
                </div>
            </div>

            <!-- 6. Karakteristik (SNI) -->
            <div>
                <label class="block text-xs font-semibold text-[#111827] mb-1.5">6. Karakteristik (SNI) <span class="text-rose-500">*</span></label>
                <textarea name="specifications" rows="5" required class="w-full rounded-xl border border-[#E5E7EB] px-3.5 py-2.5 text-xs font-mono text-[#111827] focus:border-[#0F766E] focus:outline-none focus:ring-1 focus:ring-[#0F766E] transition">{{ old('specifications', $product->specifications) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <!-- 7. Estimasi Masa Simpan -->
                <div>
                    <label class="block text-xs font-semibold text-[#111827] mb-1.5">7. Estimasi Masa Simpan <span class="text-rose-500">*</span></label>
                    <select name="unit" required class="w-full rounded-xl border border-[#E5E7EB] px-3.5 py-2.5 text-xs text-[#111827] focus:border-[#0F766E] focus:outline-none focus:ring-1 focus:ring-[#0F766E] transition">
                        @php
                            $options = ['3 Bulan', '6 Bulan', '9 Bulan', '12 Bulan', '18 Bulan', '24 Bulan'];
                        @endphp
                        @foreach ($options as $opt)
                            <option value="{{ $opt }}" {{ old('unit', $product->unit) == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Sertifikasi & Mutu (Opsional) -->
                <div>
                    <label class="block text-xs font-semibold text-[#111827] mb-1.5">Sertifikasi & Mutu (Opsional)</label>
                    <input type="text" name="serial_number" value="{{ old('serial_number', $product->serial_number) }}" placeholder="Contoh: SNI 6128:2020, Sertifikat Halal MUI" class="w-full rounded-xl border border-[#E5E7EB] px-3.5 py-2.5 text-xs text-[#111827] focus:border-[#0F766E] focus:outline-none focus:ring-1 focus:ring-[#0F766E] transition">
                </div>

                <!-- Catatan Penyimpanan (Opsional) -->
                <div>
                    <label class="block text-xs font-semibold text-[#111827] mb-1.5">Catatan Penyimpanan (Opsional)</label>
                    <input type="text" name="brand" value="{{ old('brand', $product->brand) }}" placeholder="Contoh: Simpan di tempat kering & sejuk" class="w-full rounded-xl border border-[#E5E7EB] px-3.5 py-2.5 text-xs text-[#111827] focus:border-[#0F766E] focus:outline-none focus:ring-1 focus:ring-[#0F766E] transition">
                </div>
            </div>

            <!-- Foto Beras (Opsional) -->
            <div>
                <label class="block text-xs font-semibold text-[#111827] mb-1.5">Foto Beras (Opsional)</label>
                @if ($product->image)
                    <div class="mb-2 flex items-center gap-3">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-14 w-14 rounded-lg object-cover border border-gray-200">
                        <span class="text-xs text-[#6B7280]">Foto saat ini</span>
                    </div>
                @endif
                <input type="file" name="image" accept="image/*" class="w-full rounded-xl border border-[#E5E7EB] px-3.5 py-2 text-xs text-[#6B7280] file:mr-3 file:rounded-lg file:border-0 file:bg-teal-50 file:px-3 file:py-1 file:text-xs file:font-semibold file:text-[#0F766E]">
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.products.index') }}" class="rounded-xl border border-[#E5E7EB] bg-white px-5 py-2.5 text-xs font-semibold text-[#111827] hover:bg-gray-50 transition shadow-xs">Batal</a>
            <button type="submit" class="rounded-xl bg-[#0F766E] px-6 py-2.5 text-xs font-semibold text-white hover:bg-[#115E59] transition shadow-sm flex items-center gap-2">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Perbarui Data Beras
            </button>
        </div>
    </form>

    <!-- Modal Kelola & Tambah Jenis Beras -->
    <div x-show="showCategoryModal" x-cloak 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-xs">
        <div @click.away="showCategoryModal = false" 
             class="w-full max-w-lg rounded-[16px] border border-[#E5E7EB] bg-white p-6 shadow-xl space-y-4">
            
            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <h3 class="text-base font-bold text-[#111827]">Kelola & Tambah Jenis Beras</h3>
                <button type="button" @click="showCategoryModal = false" class="text-gray-400 hover:text-gray-600 text-lg font-bold">✕</button>
            </div>

            <!-- Tab Headers -->
            <div class="flex border-b border-gray-200 gap-4 text-xs font-semibold">
                <button type="button" @click="activeTab = 'add'" :class="activeTab === 'add' ? 'border-[#0F766E] text-[#0F766E] border-b-2 font-bold' : 'text-[#6B7280] hover:text-[#111827]'" class="pb-2">
                    + Tambah Jenis Baru
                </button>
                <button type="button" @click="activeTab = 'manage'" :class="activeTab === 'manage' ? 'border-[#0F766E] text-[#0F766E] border-b-2 font-bold' : 'text-[#6B7280] hover:text-[#111827]'" class="pb-2">
                    ⚙️ Daftar & Edit / Hapus
                </button>
            </div>

            <!-- Tab 1: Tambah Jenis Baru -->
            <div x-show="activeTab === 'add'" class="space-y-4 pt-2">
                <div>
                    <label class="block text-xs font-semibold text-[#111827] mb-1">Nama Jenis Beras <span class="text-rose-500">*</span></label>
                    <input type="text" x-model="newCatName" placeholder="Contoh: Beras Pandan Wangi" class="w-full rounded-xl border border-[#E5E7EB] px-3.5 py-2 text-xs text-[#111827] focus:border-[#0F766E] focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#111827] mb-1">Deskripsi Singkat (Opsional)</label>
                    <input type="text" x-model="newCatDesc" placeholder="Keterangan jenis beras" class="w-full rounded-xl border border-[#E5E7EB] px-3.5 py-2 text-xs text-[#111827] focus:border-[#0F766E] focus:outline-none">
                </div>

                <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-100">
                    <button type="button" @click="showCategoryModal = false" class="rounded-xl border border-[#E5E7EB] bg-white px-4 py-2 text-xs font-semibold text-[#111827]">Batal</button>
                    <button type="button" @click="submitNewCategory()" :disabled="isSubmitting" class="rounded-xl bg-[#0F766E] px-4 py-2 text-xs font-semibold text-white hover:bg-[#115E59]">
                        <span x-show="!isSubmitting">Simpan & Gunakan</span>
                        <span x-show="isSubmitting">Menyimpan...</span>
                    </button>
                </div>
            </div>

            <!-- Tab 2: Daftar & Edit / Hapus Jenis Beras -->
            <div x-show="activeTab === 'manage'" class="space-y-3 pt-2 max-h-72 overflow-y-auto pr-1">
                <template x-for="cat in categoryList" :key="cat.id">
                    <div class="flex items-center justify-between p-2.5 rounded-xl border border-gray-100 bg-[#F8FAFC] text-xs">
                        <template x-if="editingId !== cat.id">
                            <div class="flex-1 flex items-center justify-between pr-3">
                                <span class="font-bold text-[#111827]" x-text="cat.name"></span>
                                <div class="flex items-center gap-1.5">
                                    <button type="button" @click="startEdit(cat)" class="px-2.5 py-1 rounded-lg bg-teal-50 text-[#0F766E] border border-teal-200 text-[11px] font-semibold hover:bg-[#0F766E] hover:text-white transition">
                                        Edit
                                    </button>
                                    <button type="button" @click="deleteCategory(cat.id, cat.name)" class="px-2.5 py-1 rounded-lg bg-rose-50 text-rose-700 border border-rose-200 text-[11px] font-semibold hover:bg-rose-600 hover:text-white transition">
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        </template>

                        <!-- Inline Edit Mode -->
                        <template x-if="editingId === cat.id">
                            <div class="flex-1 flex items-center gap-2">
                                <input type="text" x-model="editCatName" class="flex-1 rounded-lg border border-[#0F766E] px-2.5 py-1 text-xs text-[#111827]">
                                <button type="button" @click="saveEdit(cat.id)" class="px-2.5 py-1 rounded-lg bg-[#0F766E] text-white text-[11px] font-semibold">Simpan</button>
                                <button type="button" @click="editingId = null" class="px-2.5 py-1 rounded-lg bg-gray-200 text-[#111827] text-[11px]">Batal</button>
                            </div>
                        </template>
                    </div>
                </template>

                <div x-show="categoryList.length === 0" class="text-center py-6 text-xs text-gray-400">
                    Belum ada jenis beras terdaftar.
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function editProductForm() {
        return {
            showCategoryModal: false,
            activeTab: 'add',
            newCatName: '',
            newCatDesc: '',
            isSubmitting: false,
            editingId: null,
            editCatName: '',
            categoryList: [
                @foreach ($categories as $cat)
                    { id: {{ $cat->id }}, name: "{{ addslashes($cat->name) }}" },
                @endforeach
            ],

            async submitNewCategory() {
                if (!this.newCatName.trim()) {
                    alert('Silakan isi nama jenis beras.');
                    return;
                }
                this.isSubmitting = true;
                try {
                    const response = await fetch("{{ route('admin.categories.store') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            name: this.newCatName,
                            description: this.newCatDesc
                        })
                    });
                    const data = await response.json();
                    if (response.ok && data.success) {
                        const selectEl = document.getElementById('category_select');
                        const newOption = new Option(data.category.name, data.category.id, true, true);
                        selectEl.add(newOption);
                        this.categoryList.push({ id: data.category.id, name: data.category.name });
                        this.showCategoryModal = false;
                        this.newCatName = '';
                        this.newCatDesc = '';
                    } else {
                        alert(data.message || 'Gagal menambahkan jenis beras.');
                    }
                } catch (err) {
                    alert('Terjadi kesalahan koneksi.');
                } finally {
                    this.isSubmitting = false;
                }
            },

            startEdit(cat) {
                this.editingId = cat.id;
                this.editCatName = cat.name;
            },

            async saveEdit(id) {
                if (!this.editCatName.trim()) return;
                try {
                    const response = await fetch(`/admin/categories/${id}`, {
                        method: "PUT",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({ name: this.editCatName })
                    });
                    const data = await response.json();
                    if (response.ok && data.success) {
                        const idx = this.categoryList.findIndex(c => c.id === id);
                        if (idx !== -1) this.categoryList[idx].name = data.category.name;

                        // Update select dropdown option text
                        const selectEl = document.getElementById('category_select');
                        for (let opt of selectEl.options) {
                            if (parseInt(opt.value) === id) {
                                opt.text = data.category.name;
                            }
                        }
                        this.editingId = null;
                    } else {
                        alert(data.message || 'Gagal mengubah jenis beras.');
                    }
                } catch (err) {
                    alert('Terjadi kesalahan koneksi.');
                }
            },

            async deleteCategory(id, name) {
                if (!confirm(`Apakah Anda yakin ingin menghapus jenis beras "${name}"?`)) return;
                try {
                    const response = await fetch(`/admin/categories/${id}`, {
                        method: "DELETE",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        }
                    });
                    const data = await response.json();
                    if (response.ok && data.success) {
                        this.categoryList = this.categoryList.filter(c => c.id !== id);

                        // Remove option from select dropdown
                        const selectEl = document.getElementById('category_select');
                        for (let i = 0; i < selectEl.options.length; i++) {
                            if (parseInt(selectEl.options[i].value) === id) {
                                selectEl.remove(i);
                                break;
                            }
                        }
                    } else {
                        alert(data.message || 'Gagal menghapus jenis beras.');
                    }
                } catch (err) {
                    alert('Terjadi kesalahan koneksi.');
                }
            }
        }
    }
</script>
@endsection
