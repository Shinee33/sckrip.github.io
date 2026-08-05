@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto space-y-6 text-center">
    <div>
        <span class="px-3 py-1 rounded-md bg-teal-50 text-[#0F766E] text-xs font-bold uppercase tracking-wider border border-teal-200">
            Realtime Camera Scanner
        </span>
        <h1 class="mt-2.5 text-2xl font-bold text-[#111827]">Scan QR Code Barang</h1>
        <p class="mt-1 text-xs text-[#6B7280]">Arahkan kamera HP atau scanner ke QR Code pada label barang untuk langsung membuka detail produk.</p>
    </div>

    <!-- Scanner Container -->
    <div class="rounded-[14px] border border-[#E5E7EB] bg-white p-6 shadow-xs relative overflow-hidden">
        <div id="qr-reader" class="mx-auto w-full rounded-xl overflow-hidden border border-[#E5E7EB] bg-[#F8FAFC]"></div>
        
        <div id="scan-result" class="hidden mt-4 p-4 rounded-xl bg-teal-50 border border-teal-200 text-[#0F766E] text-xs font-semibold">
            Mengarahkan ke detail produk...
        </div>
    </div>

    <div class="flex justify-center gap-3">
        <a href="{{ route('user.dashboard') }}" class="px-5 py-2.5 rounded-xl border border-[#E5E7EB] bg-white text-xs font-semibold text-[#111827] hover:bg-gray-50 shadow-xs transition">
            &larr; Kembali ke Dashboard
        </a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        function onScanSuccess(decodedText, decodedResult) {
            console.log(`Scan Result: ${decodedText}`);
            const resultBox = document.getElementById('scan-result');
            resultBox.classList.remove('hidden');
            resultBox.innerText = `QR Terbaca: ${decodedText}. Mengalihkan...`;

            // If decodedText is full URL or relative path
            if (decodedText.startsWith('http') || decodedText.startsWith('/')) {
                window.location.href = decodedText;
            } else {
                // Treat as SKU / product code
                window.location.href = `/product/${encodeURIComponent(decodedText)}`;
            }
        }

        function onScanFailure(error) {
            // Silence repetitive scan frame warnings
        }

        let html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader",
            { fps: 10, qrbox: { width: 250, height: 250 } },
            /* verbose= */ false
        );

        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    });
</script>
@endsection
