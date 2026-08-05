@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-[#111827]">System Settings</h1>
        <p class="text-xs text-[#6B7280]">Pengaturan umum konfigurasi sistem inventaris enterprise.</p>
    </div>

    <div class="rounded-[14px] border border-[#E5E7EB] bg-white p-8 shadow-xs">
        <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-[#111827] uppercase tracking-wider">Nama Perusahaan / Sistem</label>
                <input type="text" name="app_name" value="Enterprise Inventory Management" required
                    class="mt-1.5 w-full h-10 rounded-xl border border-[#E5E7EB] bg-white px-4 text-sm text-[#111827] focus:border-[#0F766E] focus:ring-1 focus:ring-[#0F766E] focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold text-[#111827] uppercase tracking-wider">Batas Stok Minimum Default (Alert)</label>
                <input type="number" name="default_min_stock" value="5" min="1" required
                    class="mt-1.5 w-full h-10 rounded-xl border border-[#E5E7EB] bg-white px-4 text-sm text-[#111827] focus:border-[#0F766E] focus:ring-1 focus:ring-[#0F766E] focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold text-[#111827] uppercase tracking-wider">Format Penamaan Kode QR Default</label>
                <input type="text" name="qr_prefix" value="PRD-" required readonly
                    class="mt-1.5 w-full h-10 rounded-xl border border-[#E5E7EB] bg-[#F8FAFC] px-4 text-sm font-mono text-[#0F766E] font-bold focus:outline-none">
            </div>

            <div class="pt-4 border-t border-[#E5E7EB] flex justify-end">
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#0F766E] text-xs font-semibold text-white hover:bg-[#115E59] shadow-xs transition">
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
