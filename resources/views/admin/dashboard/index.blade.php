@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Header Banner -->
    <div class="rounded-[14px] border border-[#E5E7EB] bg-white p-6 sm:p-8 shadow-xs relative overflow-hidden">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between relative z-10">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-[#0F766E] bg-teal-50 px-2.5 py-1 rounded-md border border-teal-100">Ringkasan Beras & SNI</span>
                <h1 class="mt-2.5 text-[32px] font-bold text-[#111827] leading-tight">Dashboard Admin Beras</h1>
                <p class="mt-1 text-sm text-[#6B7280]">Kelola data varietas beras, karakteristik SNI, lokasi tanam, dan unduh QR Code.</p>
            </div>
            <div class="flex flex-wrap gap-2.5">
                <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-[#0F766E] px-4 py-2.5 text-xs font-semibold text-white hover:bg-[#115E59] shadow-xs transition">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    + Tambah Data Beras
                </a>
                <a href="{{ route('admin.products.export') }}" class="inline-flex items-center gap-2 rounded-xl border border-[#E5E7EB] bg-white px-4 py-2.5 text-xs font-semibold text-[#111827] hover:bg-gray-50 shadow-xs transition">
                    <svg class="h-4 w-4 text-[#0F766E]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Export CSV
                </a>
            </div>
        </div>
    </div>

    <!-- Stat Cards Grid -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <div class="rounded-[14px] border border-[#E5E7EB] bg-white p-5 shadow-xs hover:border-teal-200 transition">
            <span class="text-[11px] font-bold text-[#6B7280] uppercase tracking-wider">Total Data Beras</span>
            <p class="mt-2 text-3xl font-bold text-[#111827]">{{ number_format($stats['total_products']) }}</p>
            <span class="mt-1 inline-block text-[11px] text-[#6B7280]">Varietas terdaftar</span>
        </div>

        <div class="rounded-[14px] border border-[#E5E7EB] bg-white p-5 shadow-xs hover:border-teal-200 transition">
            <span class="text-[11px] font-bold text-[#6B7280] uppercase tracking-wider">Jenis Beras</span>
            <p class="mt-2 text-3xl font-bold text-[#111827]">{{ number_format($stats['total_categories']) }}</p>
            <span class="mt-1 inline-block text-[11px] text-[#6B7280]">Kategori terklasifikasi</span>
        </div>

        <div class="rounded-[14px] border border-emerald-200 bg-emerald-50/50 p-5 shadow-xs transition">
            <span class="text-[11px] font-bold text-emerald-800 uppercase tracking-wider">Beras Aktif (SNI)</span>
            <p class="mt-2 text-3xl font-bold text-emerald-700">{{ number_format($stats['active_products']) }}</p>
            <span class="mt-1 inline-block text-[11px] text-emerald-600">Siap dipindai QR</span>
        </div>

        <div class="rounded-[14px] border border-teal-200 bg-teal-50/50 p-5 shadow-xs transition">
            <span class="text-[11px] font-bold text-[#0F766E] uppercase tracking-wider">Status Sertifikasi</span>
            <p class="mt-2 text-3xl font-bold text-[#0F766E]">SNI 6128</p>
            <span class="mt-1 inline-block text-[11px] text-[#0F766E]">Standar Mutu Beras</span>
        </div>
    </div>

    <!-- Charts & Analytics Section -->
    <div class="rounded-[14px] border border-[#E5E7EB] bg-white p-6 shadow-xs">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-lg font-bold text-[#111827]">Grafik Registrasi Beras</h2>
                <p class="text-xs text-[#6B7280]">Perkembangan data beras masuk 6 bulan terakhir</p>
            </div>
            <div class="flex items-center gap-4 text-xs font-semibold">
                <span class="flex items-center gap-1.5 text-[#0F766E]"><span class="h-3 w-3 rounded-full bg-[#0F766E] inline-block"></span> Data Beras Terdaftar</span>
            </div>
        </div>
        <div class="h-72 w-full">
            <canvas id="inventoryChart"></canvas>
        </div>
    </div>

    <!-- 10 Latest Products Table -->
    <div class="rounded-[14px] border border-[#E5E7EB] bg-white p-6 shadow-xs">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-base font-bold text-[#111827]">10 Data Beras Terbaru</h2>
            <a href="{{ route('admin.products.index') }}" class="text-xs font-semibold text-[#0F766E] hover:underline">Lihat Semua Data Beras &rarr;</a>
        </div>
        <div class="overflow-x-auto rounded-xl border border-[#E5E7EB]">
            <table class="w-full text-left text-xs">
                <thead class="bg-[#F8FAFC] text-[#6B7280] uppercase tracking-wider font-bold border-b border-[#E5E7EB]">
                    <tr>
                        <th class="px-4 py-3">Nama Beras</th>
                        <th class="px-4 py-3">Jenis Beras</th>
                        <th class="px-4 py-3">Lokasi Tanam</th>
                        <th class="px-4 py-3">Waktu Panen</th>
                        <th class="px-4 py-3">Masa Simpan</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E5E7EB]">
                    @forelse($latest_products as $p)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 font-bold text-[#111827]">
                            <a href="{{ route('admin.products.show', $p) }}" class="hover:text-[#0F766E] transition">
                                {{ $p->name }}
                            </a>
                        </td>
                        <td class="px-4 py-3 font-bold text-[#0F766E]">{{ $p->category?->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-[#6B7280]">{{ $p->location ?? '-' }}</td>
                        <td class="px-4 py-3 text-[#6B7280]">{{ $p->entry_date ? $p->entry_date->format('d/m/Y') : '-' }}</td>
                        <td class="px-4 py-3 font-semibold text-[#111827]">{{ $p->unit ?? '12 Bulan' }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.products.show', $p) }}" class="px-2.5 py-1 rounded-lg bg-teal-50 text-[#0F766E] border border-teal-200 text-[11px] font-semibold hover:bg-[#0F766E] hover:text-white transition">
                                Detail / QR
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-[#6B7280]">Belum ada data beras terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('inventoryChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($chart['labels']),
                datasets: [
                    {
                        label: 'Data Beras Terdaftar',
                        data: @json($chart['incoming']),
                        borderColor: '#0F766E',
                        backgroundColor: 'rgba(15, 118, 110, 0.08)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        grid: { color: '#E5E7EB' },
                        ticks: { color: '#6B7280' }
                    },
                    y: {
                        grid: { color: '#E5E7EB' },
                        ticks: { color: '#6B7280' },
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endsection
