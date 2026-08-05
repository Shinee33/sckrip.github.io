<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak QR Label - {{ $product->code }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { background: white !important; color: black !important; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body class="bg-slate-100 min-h-screen flex flex-col items-center justify-center p-6" onload="window.print()">

    <div class="no-print mb-6 flex gap-3">
        <button onclick="window.print()" class="px-5 py-2.5 rounded-xl bg-emerald-600 text-white font-semibold text-sm shadow-lg hover:bg-emerald-500">
            🖨️ Cetak Label Sekarang
        </button>
        <button onclick="window.close()" class="px-5 py-2.5 rounded-xl bg-slate-800 text-white font-semibold text-sm hover:bg-slate-700">
            Tutup
        </button>
    </div>

    <!-- Printable Asset Label Badge -->
    <div class="w-80 bg-white border-2 border-slate-950 rounded-2xl p-4 shadow-xl text-slate-950 text-center font-sans">
        <div class="border-b-2 border-slate-950 pb-2 mb-3">
            <span class="text-[10px] font-bold tracking-widest uppercase block text-slate-600">Properti Inventaris Perusahaan</span>
            <h2 class="text-base font-extrabold tracking-tight uppercase leading-tight">{{ $product->name }}</h2>
        </div>

        <div class="my-2 flex justify-center">
            {!! $qrSvg !!}
        </div>

        <div class="mt-3 pt-2 border-t border-slate-300 font-mono text-xs space-y-0.5">
            <div class="font-extrabold text-sm tracking-wider text-slate-950">KODE: {{ $product->code }}</div>
            @if($product->serial_number)
                <div class="text-[11px] text-slate-700">SN: {{ $product->serial_number }}</div>
            @endif
            <div class="text-[10px] text-slate-600 mt-1 font-sans">Lokasi: {{ $product->location ?? '-' }} &bull; Status: {{ $product->status?->label() }}</div>
        </div>
    </div>

</body>
</html>
