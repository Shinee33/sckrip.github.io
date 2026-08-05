<!DOCTYPE html>
<html lang="id" class="h-full bg-[#F8FAFC]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Inventory System' }} - Enterprise Asset Management</title>
    
    <!-- Google Fonts Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS & Vite assets -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

    <!-- Alpine.js & Chart.js & HTML5 QR Scanner -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
</head>
<body class="min-h-full bg-[#F8FAFC] text-[#111827] antialiased selection:bg-[#0F766E] selection:text-white" x-data="{ mobileMenuOpen: false }">
    <div class="min-h-screen flex flex-col">
        <!-- Top Navbar (~70px height) -->
        <header class="sticky top-0 z-40 h-[70px] border-b border-[#E5E7EB] bg-white shadow-xs">
            <div class="mx-auto h-full max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-full items-center justify-between gap-4">
                    
                    @if(request()->is('admin*'))
                        <!-- ADMIN NAVBAR -->
                        <div class="flex items-center gap-6">
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#0F766E] text-white shadow-sm">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m-8-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-[10px] font-bold tracking-wider text-[#0F766E] uppercase bg-teal-50 px-2 py-0.5 rounded border border-teal-200">Web Admin</span>
                                    <h1 class="text-base font-bold text-[#111827] leading-none mt-0.5">INVENTORY</h1>
                                </div>
                            </a>

                            <!-- Desktop Admin Nav Links -->
                            <nav class="hidden lg:flex items-center gap-1 ml-4">
                                <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.dashboard') ? 'bg-teal-50 text-[#0F766E]' : 'text-[#6B7280] hover:text-[#111827] hover:bg-gray-50' }}">Dashboard</a>
                                <a href="{{ route('admin.products.index') }}" class="px-3 py-2 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.products.*') ? 'bg-teal-50 text-[#0F766E]' : 'text-[#6B7280] hover:text-[#111827] hover:bg-gray-50' }}">Data Beras</a>
                                <a href="{{ route('admin.categories.index') }}" class="px-3 py-2 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.categories.*') ? 'bg-teal-50 text-[#0F766E]' : 'text-[#6B7280] hover:text-[#111827] hover:bg-gray-50' }}">Jenis Beras</a>
                                <a href="{{ route('admin.qr.index') }}" class="px-3 py-2 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.qr.*') ? 'bg-teal-50 text-[#0F766E]' : 'text-[#6B7280] hover:text-[#111827] hover:bg-gray-50' }}">QR Code</a>
                                <a href="{{ route('admin.users.index') }}" class="px-3 py-2 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.users.*') ? 'bg-teal-50 text-[#0F766E]' : 'text-[#6B7280] hover:text-[#111827] hover:bg-gray-50' }}">Pengguna (Admin)</a>
                                <a href="{{ route('admin.settings.index') }}" class="px-3 py-2 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.settings.*') ? 'bg-teal-50 text-[#0F766E]' : 'text-[#6B7280] hover:text-[#111827] hover:bg-gray-50' }}">Pengaturan</a>
                            </nav>
                        </div>

                        <!-- Admin Profile & Logout -->
                        <div class="flex items-center gap-3">
                            @auth
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" class="flex items-center gap-2.5 rounded-xl border border-[#E5E7EB] bg-white px-3 py-1.5 hover:border-gray-300 transition shadow-xs">
                                        <div class="h-7 w-7 rounded-lg bg-teal-100 text-[#0F766E] flex items-center justify-center font-bold text-xs">
                                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                        </div>
                                        <div class="hidden sm:block text-left">
                                            <div class="text-xs font-semibold text-[#111827]">{{ auth()->user()->name }}</div>
                                            <div class="text-[10px] text-[#6B7280] uppercase tracking-wider">Admin</div>
                                        </div>
                                        <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>

                                    <div x-show="open" @click.away="open = false" x-cloak x-transition class="absolute right-0 mt-2 w-48 rounded-xl border border-[#E5E7EB] bg-white p-1.5 shadow-lg z-50">
                                        <div class="px-3 py-2 border-b border-gray-100 text-xs">
                                            <p class="font-semibold text-[#111827]">{{ auth()->user()->name }}</p>
                                            <p class="text-[#6B7280] truncate text-[11px]">{{ auth()->user()->email }}</p>
                                        </div>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="w-full mt-1 flex items-center gap-2 px-3 py-2 text-xs font-medium text-rose-600 rounded-lg hover:bg-rose-50 transition">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                                </svg>
                                                Logout Admin
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endauth

                            <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                </svg>
                            </button>
                        </div>
                    @else
                        <!-- USER NAVBAR (CLEAN, NO ADMIN LOGIN BUTTON) -->
                        <div class="flex items-center gap-6">
                            <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#0F766E] text-white shadow-sm">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m-8-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-[10px] font-bold tracking-wider text-[#0F766E] uppercase">Enterprise</span>
                                    <h1 class="text-base font-bold text-[#111827] leading-none mt-0.5">INVENTORY</h1>
                                </div>
                            </a>

                            <!-- Desktop User Nav Links -->
                            <nav class="hidden md:flex items-center gap-1 ml-4">
                                <a href="{{ route('user.dashboard') }}" class="px-3.5 py-2 rounded-lg text-xs font-semibold transition {{ request()->routeIs('user.dashboard') ? 'bg-teal-50 text-[#0F766E]' : 'text-[#6B7280] hover:text-[#111827] hover:bg-gray-50' }}">Dashboard</a>
                                <a href="{{ route('user.products.index') }}" class="px-3.5 py-2 rounded-lg text-xs font-semibold transition {{ request()->routeIs('user.products.*') ? 'bg-teal-50 text-[#0F766E]' : 'text-[#6B7280] hover:text-[#111827] hover:bg-gray-50' }}">Daftar Barang</a>
                                <a href="{{ route('user.scan') }}" class="px-3.5 py-2 rounded-lg text-xs font-semibold transition {{ request()->routeIs('user.scan') ? 'bg-teal-50 text-[#0F766E]' : 'text-[#6B7280] hover:text-[#111827] hover:bg-gray-50' }}">Scan QR</a>
                            </nav>
                        </div>

                        <!-- Right Side User Actions -->
                        <div class="flex items-center gap-3">
                            <a href="{{ route('user.scan') }}" class="inline-flex items-center gap-2 rounded-xl border border-[#0F766E] px-3.5 py-1.5 text-xs font-semibold text-[#0F766E] hover:bg-[#0F766E] hover:text-white transition shadow-xs">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                </svg>
                                <span>Scan QR</span>
                            </a>

                            <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                </svg>
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Mobile Navigation -->
            <div x-show="mobileMenuOpen" x-cloak class="border-b border-[#E5E7EB] bg-white px-4 py-3 space-y-1 shadow-md">
                @if(request()->is('admin*'))
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-lg text-xs font-semibold text-gray-700 hover:bg-gray-50">Dashboard</a>
                    <a href="{{ route('admin.products.index') }}" class="block px-3 py-2 rounded-lg text-xs font-semibold text-gray-700 hover:bg-gray-50">Barang</a>
                    <a href="{{ route('admin.categories.index') }}" class="block px-3 py-2 rounded-lg text-xs font-semibold text-gray-700 hover:bg-gray-50">Kategori</a>
                    <a href="{{ route('admin.qr.index') }}" class="block px-3 py-2 rounded-lg text-xs font-semibold text-gray-700 hover:bg-gray-50">QR Code</a>
                    <a href="{{ route('admin.users.index') }}" class="block px-3 py-2 rounded-lg text-xs font-semibold text-gray-700 hover:bg-gray-50">User</a>
                    <a href="{{ route('admin.logs.index') }}" class="block px-3 py-2 rounded-lg text-xs font-semibold text-gray-700 hover:bg-gray-50">Log Aktivitas</a>
                    <a href="{{ route('admin.settings.index') }}" class="block px-3 py-2 rounded-lg text-xs font-semibold text-gray-700 hover:bg-gray-50">Settings</a>
                @else
                    <a href="{{ route('user.dashboard') }}" class="block px-3 py-2 rounded-lg text-xs font-semibold text-gray-700 hover:bg-gray-50">Dashboard</a>
                    <a href="{{ route('user.products.index') }}" class="block px-3 py-2 rounded-lg text-xs font-semibold text-gray-700 hover:bg-gray-50">Daftar Barang</a>
                    <a href="{{ route('user.scan') }}" class="block px-3 py-2 rounded-lg text-xs font-semibold text-gray-700 hover:bg-gray-50">Scan QR</a>
                @endif
            </div>
        </header>

        <!-- Toast Notifications -->
        <div class="fixed bottom-5 right-5 z-50 space-y-2 max-w-sm" x-data="{ show: true }">
            @if (session('success'))
                <div x-show="show" x-init="setTimeout(() => show = false, 4000)" class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-white p-4 text-xs text-emerald-800 shadow-lg">
                    <svg class="h-5 w-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div x-show="show" x-init="setTimeout(() => show = false, 5000)" class="flex items-center gap-3 rounded-xl border border-rose-200 bg-white p-4 text-xs text-rose-800 shadow-lg">
                    <svg class="h-5 w-5 text-rose-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            @endif
        </div>

        <!-- Main Content Body -->
        <main class="flex-1 px-4 py-8 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl">
                {{ $slot ?? '' }}
                @yield('content')
            </div>
        </main>

        <!-- Footer -->
        <footer class="border-t border-[#E5E7EB] bg-white py-5 text-center text-xs text-[#6B7280]">
            <div class="mx-auto max-w-7xl px-4">
                &copy; {{ date('Y') }} Enterprise Inventory Management System. All rights reserved.
            </div>
        </footer>
    </div>
</body>
</html>