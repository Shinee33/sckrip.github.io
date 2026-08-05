@extends('layouts.app')

@section('content')
<div class="space-y-6" x-data="{ createModal: false }">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-[#111827]">User Management</h1>
            <p class="text-xs text-[#6B7280]">Kelola daftar pengguna sistem, alokasi role Admin & User, serta status akun.</p>
        </div>
        <button @click="createModal = true" class="inline-flex items-center gap-2 rounded-xl bg-[#0F766E] px-4 py-2 text-xs font-semibold text-white hover:bg-[#115E59] shadow-xs transition">
            + Tambah User Baru
        </button>
    </div>

    <!-- User Table -->
    <div class="overflow-hidden rounded-[14px] border border-[#E5E7EB] bg-white shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-[#F8FAFC] text-[#6B7280] uppercase tracking-wider font-bold border-b border-[#E5E7EB]">
                    <tr>
                        <th class="px-5 py-4">Pengguna</th>
                        <th class="px-4 py-4">Role</th>
                        <th class="px-4 py-4">Status</th>
                        <th class="px-4 py-4">Login Terakhir</th>
                        <th class="px-5 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E5E7EB]">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-4">
                            <div class="font-bold text-[#111827] text-sm">{{ $user->name }}</div>
                            <div class="text-[#6B7280] text-[11px]">{{ $user->email }}</div>
                        </td>
                        <td class="px-4 py-4">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold uppercase {{ $user->isAdmin() ? 'bg-teal-50 text-[#0F766E] border border-teal-200' : 'bg-slate-100 text-slate-700 border border-slate-200' }}">
                                {{ $user->role?->label() ?? $user->role }}
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $user->status === 'active' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-[#6B7280] font-medium">{{ $user->last_login_at?->diffForHumans() ?? 'Belum pernah' }}</td>
                        <td class="px-5 py-4 text-right space-x-1.5">
                            @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline-block" onsubmit="return confirm('Hapus akun pengguna ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 rounded-lg bg-rose-50 text-rose-700 border border-rose-200 text-[11px] font-semibold hover:bg-rose-600 hover:text-white transition shadow-xs">
                                    Hapus
                                </button>
                            </form>
                            @else
                            <span class="text-[10px] text-[#6B7280] italic">Akun Anda</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-4 py-8 text-center text-[#6B7280]">Tidak ada data pengguna.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Create User -->
    <div x-show="createModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-xs">
        <div @click.away="createModal = false" class="w-full max-w-md rounded-[14px] border border-[#E5E7EB] bg-white p-6 shadow-lg space-y-4">
            <h3 class="text-lg font-bold text-[#111827]">Tambah Pengguna Baru</h3>
            <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-[#111827] uppercase">Nama Lengkap *</label>
                    <input type="text" name="name" required class="mt-1.5 w-full h-10 rounded-xl border border-[#E5E7EB] bg-white px-4 text-sm text-[#111827] focus:border-[#0F766E] focus:ring-1 focus:ring-[#0F766E] focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-[#111827] uppercase">Email *</label>
                    <input type="email" name="email" required class="mt-1.5 w-full h-10 rounded-xl border border-[#E5E7EB] bg-white px-4 text-sm text-[#111827] focus:border-[#0F766E] focus:ring-1 focus:ring-[#0F766E] focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-[#111827] uppercase">Kata Sandi *</label>
                    <input type="password" name="password" required class="mt-1.5 w-full h-10 rounded-xl border border-[#E5E7EB] bg-white px-4 text-sm text-[#111827] focus:border-[#0F766E] focus:ring-1 focus:ring-[#0F766E] focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-[#111827] uppercase">Hak Akses Role *</label>
                    <select name="role" required class="mt-1.5 w-full h-10 rounded-xl border border-[#E5E7EB] bg-white px-4 text-sm text-[#111827] focus:border-[#0F766E] focus:ring-1 focus:ring-[#0F766E] focus:outline-none">
                        <option value="admin">Admin (Hak Penuh)</option>
                        <option value="user" selected>User (Read-only & Scan)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-[#111827] uppercase">Status Akun *</label>
                    <select name="status" required class="mt-1.5 w-full h-10 rounded-xl border border-[#E5E7EB] bg-white px-4 text-sm text-[#111827] focus:border-[#0F766E] focus:ring-1 focus:ring-[#0F766E] focus:outline-none">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="flex justify-end gap-2 pt-2 border-t border-[#E5E7EB]">
                    <button type="button" @click="createModal = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-[#6B7280] hover:text-[#111827]">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-[#0F766E] text-xs font-semibold text-white hover:bg-[#115E59]">Simpan User</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
