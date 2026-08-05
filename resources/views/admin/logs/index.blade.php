@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-[#111827]">Activity Log Audit Trail</h1>
        <p class="text-xs text-[#6B7280]">Jejak audit lengkap seluruh aktivitas pengguna, transaksi inventaris, dan peristiwa sistem secara akurat.</p>
    </div>

    <div class="overflow-hidden rounded-[14px] border border-[#E5E7EB] bg-white shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-[#F8FAFC] text-[#6B7280] uppercase tracking-wider font-bold border-b border-[#E5E7EB]">
                    <tr>
                        <th class="px-5 py-4">Waktu</th>
                        <th class="px-4 py-4">Pengguna</th>
                        <th class="px-4 py-4">Aksi</th>
                        <th class="px-4 py-4">Deskripsi Aktivitas</th>
                        <th class="px-4 py-4">IP Address</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E5E7EB]">
                    @forelse($logs as $log)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-4 text-[#6B7280] font-mono text-[11px] whitespace-nowrap">
                            {{ $log->created_at->format('Y-m-d H:i:s') }}
                        </td>
                        <td class="px-4 py-4 font-bold text-[#111827]">
                            {{ $log->user?->name ?? 'System Guest' }}
                        </td>
                        <td class="px-4 py-4 font-mono">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-teal-50 text-[#0F766E] border border-teal-200">
                                {{ $log->action }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-[#111827]">{{ $log->description }}</td>
                        <td class="px-4 py-4 font-mono text-[#6B7280] text-[11px]">{{ $log->ip_address ?? '127.0.0.1' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-4 py-8 text-center text-[#6B7280]">Belum ada riwayat log.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
        <div class="p-4 border-t border-[#E5E7EB]">
            {{ $logs->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
