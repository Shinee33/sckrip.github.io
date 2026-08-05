<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Product</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="min-h-full bg-slate-950 text-slate-100">
<div class="min-h-screen px-4 py-10 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-3xl rounded-3xl border border-slate-800 bg-slate-900/70 p-8 shadow-2xl shadow-slate-950/40 backdrop-blur">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.35em] text-emerald-400">New Product</p>
                <h1 class="mt-2 text-3xl font-semibold text-white">Create Product</h1>
            </div>
            <a href="{{ route('products.index') }}" class="text-sm font-medium text-slate-400 transition hover:text-slate-200">Back</a>
        </div>

        <form action="{{ route('products.store') }}" method="POST" class="mt-8 space-y-6">
            @csrf
            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-300" for="name">Product Name</label>
                    <input id="name" name="name" value="{{ old('name') }}" class="w-full rounded-2xl border border-slate-700 bg-slate-950/70 px-4 py-3 text-sm text-white outline-none ring-0" required>
                    @error('name')<p class="mt-2 text-sm text-rose-400">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-300" for="sku">SKU</label>
                    <input id="sku" name="sku" value="{{ old('sku') }}" class="w-full rounded-2xl border border-slate-700 bg-slate-950/70 px-4 py-3 text-sm text-white outline-none ring-0" required>
                    @error('sku')<p class="mt-2 text-sm text-rose-400">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-300" for="barcode">Barcode</label>
                    <input id="barcode" name="barcode" value="{{ old('barcode') }}" class="w-full rounded-2xl border border-slate-700 bg-slate-950/70 px-4 py-3 text-sm text-white outline-none ring-0">
                    @error('barcode')<p class="mt-2 text-sm text-rose-400">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-300" for="category_id">Category</label>
                    <select id="category_id" name="category_id" class="w-full rounded-2xl border border-slate-700 bg-slate-950/70 px-4 py-3 text-sm text-white outline-none ring-0" required>
                        <option value="">Select category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<p class="mt-2 text-sm text-rose-400">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-300" for="purchase_price">Purchase Price</label>
                    <input id="purchase_price" name="purchase_price" type="number" step="0.01" value="{{ old('purchase_price') }}" class="w-full rounded-2xl border border-slate-700 bg-slate-950/70 px-4 py-3 text-sm text-white outline-none ring-0" required>
                    @error('purchase_price')<p class="mt-2 text-sm text-rose-400">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-300" for="selling_price">Selling Price</label>
                    <input id="selling_price" name="selling_price" type="number" step="0.01" value="{{ old('selling_price') }}" class="w-full rounded-2xl border border-slate-700 bg-slate-950/70 px-4 py-3 text-sm text-white outline-none ring-0" required>
                    @error('selling_price')<p class="mt-2 text-sm text-rose-400">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-300" for="min_stock_alert">Low Stock Alert</label>
                    <input id="min_stock_alert" name="min_stock_alert" type="number" min="1" value="{{ old('min_stock_alert', 5) }}" class="w-full rounded-2xl border border-slate-700 bg-slate-950/70 px-4 py-3 text-sm text-white outline-none ring-0" required>
                    @error('min_stock_alert')<p class="mt-2 text-sm text-rose-400">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-300" for="status">Status</label>
                    <select id="status" name="status" class="w-full rounded-2xl border border-slate-700 bg-slate-950/70 px-4 py-3 text-sm text-white outline-none ring-0">
                        <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="discontinued" {{ old('status') === 'discontinued' ? 'selected' : '' }}>Discontinued</option>
                    </select>
                    @error('status')<p class="mt-2 text-sm text-rose-400">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-slate-300" for="description">Description</label>
                <textarea id="description" name="description" rows="4" class="w-full rounded-2xl border border-slate-700 bg-slate-950/70 px-4 py-3 text-sm text-white outline-none ring-0">{{ old('description') }}</textarea>
                @error('description')<p class="mt-2 text-sm text-rose-400">{{ $message }}</p>@enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="rounded-2xl bg-emerald-500 px-5 py-2.5 text-sm font-semibold text-slate-950 transition hover:bg-emerald-400">Save Product</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
