<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operations Dashboard</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="min-h-full bg-slate-950 text-slate-100">
<div class="min-h-screen px-4 py-10 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl">
        <div class="rounded-3xl border border-slate-800 bg-slate-900/70 p-8 shadow-2xl shadow-slate-950/40 backdrop-blur">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.35em] text-emerald-400">Operations Dashboard</p>
                    <h1 class="mt-3 text-3xl font-semibold text-white">Business Overview</h1>
                    <p class="mt-2 max-w-2xl text-sm text-slate-400">Monitor catalog health, stock awareness, and core inventory performance in one place.</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('products.index') }}" class="rounded-2xl border border-slate-700 px-4 py-2.5 text-sm font-semibold text-slate-200 transition hover:border-emerald-500 hover:text-white">View Products</a>
                    <a href="{{ route('products.create') }}" class="rounded-2xl bg-emerald-500 px-4 py-2.5 text-sm font-semibold text-slate-950 transition hover:bg-emerald-400">Create Product</a>
                </div>
            </div>

            <div class="mt-8 grid gap-4 md:grid-cols-3">
                <div class="rounded-2xl border border-slate-800 bg-slate-950/60 p-5">
                    <p class="text-sm text-slate-400">Total Products</p>
                    <p class="mt-3 text-3xl font-semibold text-white">{{ $stats['products'] }}</p>
                </div>
                <div class="rounded-2xl border border-slate-800 bg-slate-950/60 p-5">
                    <p class="text-sm text-slate-400">Active Products</p>
                    <p class="mt-3 text-3xl font-semibold text-white">{{ $stats['active_products'] }}</p>
                </div>
                <div class="rounded-2xl border border-slate-800 bg-slate-800/60 p-5">
                    <p class="text-sm text-slate-400">Low stock alerts</p>
                    <p class="mt-3 text-3xl font-semibold text-amber-400">{{ $stats['low_stock_products'] }}</p>
                </div>
            </div>

            <div class="mt-8 grid gap-6 lg:grid-cols-[1.3fr_0.7fr]">
                <div class="rounded-2xl border border-slate-800 bg-slate-950/50 p-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-white">Inventory Pulse</h2>
                        <span class="rounded-full bg-emerald-500/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.25em] text-emerald-400">Healthy</span>
                    </div>
                    <p class="mt-4 text-sm leading-7 text-slate-400">The catalog is now equipped with a structured foundation for SKU tracking, pricing, stock thresholds, and scalable growth to support larger operational workflows.</p>
                </div>
                <div class="rounded-2xl border border-slate-800 bg-slate-950/50 p-6">
                    <h2 class="text-lg font-semibold text-white">Recommended next steps</h2>
                    <ul class="mt-4 space-y-3 text-sm text-slate-400">
                        <li>• Add stock movement tracking and warehouse visibility</li>
                        <li>• Introduce supplier and purchase order workflows</li>
                        <li>• Enable role-based access for finance and operations teams</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
