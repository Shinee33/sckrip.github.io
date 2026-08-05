<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Catalog</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="min-h-full bg-slate-950 text-slate-100">
<div class="min-h-screen">
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="rounded-3xl border border-slate-800 bg-slate-900/70 p-8 shadow-2xl shadow-slate-950/40 backdrop-blur">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.35em] text-emerald-400">Enterprise Inventory</p>
                    <h1 class="mt-3 text-3xl font-semibold text-white">Product Catalog</h1>
                    <p class="mt-2 max-w-2xl text-sm text-slate-400">Manage SKU, stock alerts, margins, and catalog visibility with a clean, scalable interface.</p>
                </div>
                <a href="{{ route('products.create') }}" class="inline-flex items-center justify-center rounded-2xl bg-emerald-500 px-4 py-2.5 text-sm font-semibold text-slate-950 transition hover:bg-emerald-400">Create Product</a>
            </div>

            <div class="mt-8 overflow-hidden rounded-2xl border border-slate-800">
                <table class="min-w-full divide-y divide-slate-800">
                    <thead class="bg-slate-800/70">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">Product</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">Category</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">Price</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">Status</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800 bg-slate-900/40">
                    @forelse($products as $product)
                        <tr class="transition hover:bg-slate-800/40">
                            <td class="px-4 py-4">
                                <div class="font-medium text-white">{{ $product->name }}</div>
                                <div class="mt-1 text-sm text-slate-400">{{ $product->sku }}</div>
                            </td>
                            <td class="px-4 py-4 text-sm text-slate-300">{{ $product->category?->name ?? 'Uncategorized' }}</td>
                            <td class="px-4 py-4 text-sm text-slate-300">{{ number_format($product->selling_price, 2) }}</td>
                            <td class="px-4 py-4">
                                <span class="inline-flex rounded-full bg-emerald-500/10 px-2.5 py-1 text-xs font-semibold text-emerald-400">{{ ucfirst($product->status) }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-10 text-center text-sm text-slate-400">No products available yet.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($products->hasPages())
                <div class="mt-6">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
</body>
</html>
