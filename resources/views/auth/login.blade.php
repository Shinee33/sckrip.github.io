<!DOCTYPE html>
<html lang="id" class="h-full bg-[#F8FAFC]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Enterprise Inventory System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="min-h-full bg-[#F8FAFC] text-[#111827] flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Logo & Header -->
        <div class="text-center mb-6">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#0F766E] text-white shadow-sm">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m-8-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <div class="mt-3">
                <span class="text-[10px] font-bold tracking-wider text-[#0F766E] uppercase bg-teal-50 px-2.5 py-1 rounded border border-teal-200">Portal Web Admin</span>
            </div>
            <h2 class="mt-2 text-2xl font-bold tracking-tight text-[#111827]">Login Administrator</h2>
            <p class="mt-1 text-xs text-[#6B7280]">Masukkan kredensial akun admin untuk mengelola inventaris</p>
        </div>

        <!-- Form Card -->
        <div class="rounded-[14px] border border-[#E5E7EB] bg-white p-8 shadow-xs">
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-[#111827]">Alamat Email Admin</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="mt-1.5 block w-full h-11 rounded-xl border border-[#E5E7EB] bg-white px-4 text-sm text-[#111827] placeholder-[#6B7280] focus:border-[#0F766E] focus:ring-1 focus:ring-[#0F766E] focus:outline-none transition">
                    @error('email')
                        <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-[#111827]">Kata Sandi</label>
                        <a href="{{ route('password.request') }}" class="text-xs text-[#0F766E] hover:underline font-medium">Lupa Sandi?</a>
                    </div>
                    <input id="password" type="password" name="password" required
                        class="mt-1.5 block w-full h-11 rounded-xl border border-[#E5E7EB] bg-white px-4 text-sm text-[#111827] placeholder-[#6B7280] focus:border-[#0F766E] focus:ring-1 focus:ring-[#0F766E] focus:outline-none transition">
                    @error('password')
                        <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input id="remember" type="checkbox" name="remember" class="h-4 w-4 rounded border-[#E5E7EB] text-[#0F766E] focus:ring-[#0F766E]">
                    <label for="remember" class="ml-2 text-xs text-[#6B7280]">Ingat akun saya (Remember me)</label>
                </div>

                <button type="submit" class="w-full h-11 rounded-xl bg-[#0F766E] px-4 text-sm font-semibold text-white hover:bg-[#115E59] shadow-xs transition">
                    Masuk Portal Admin
                </button>
            </form>

            <div class="mt-6 border-t border-[#E5E7EB] pt-4 text-xs text-[#6B7280]">
                <p class="font-semibold text-[#111827] mb-2">Akun Admin Default:</p>
                <div class="rounded-xl border border-[#E5E7EB] bg-[#F8FAFC] p-3 text-[11px]">
                    <p class="text-[#0F766E] font-bold">Administrator</p>
                    <p class="text-[#111827]">Email: <span class="font-mono">admin@inventory.com</span></p>
                    <p class="text-[#6B7280]">Password: <span class="font-mono">password</span></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
