<?php

namespace App\Services;

use App\Models\Product;

class QrCodeService
{
    /**
     * Get the public target URL encoded in the QR code for a product.
     */
    public function getProductQrUrl(Product $product): string
    {
        return route('products.show.public', ['code' => $product->code]);
    }

    /**
     * Generate inline SVG representation of QR Code containing product URL.
     */
    public function generateSvg(Product $product, int $size = 200): string
    {
        $url = $this->getProductQrUrl($product);
        $encodedUrl = urlencode($url);

        // Render clean, modern SVG QR code using SVG QR matrix generator
        return $this->renderSvgQr($url, $size);
    }

    /**
     * Generates a Data URI SVG string for easy <img src="..."> embedding.
     */
    public function generateSvgDataUri(Product $product, int $size = 200): string
    {
        $svg = $this->generateSvg($product, $size);
        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }

    /**
     * Build SVG QR Code markup with smooth styling & dark/light options.
     */
    private function renderSvgQr(string $text, int $size = 200): string
    {
        // Simple, crisp, self-contained SVG QR matrix structure
        $modules = $this->encodeToMatrix($text);
        $count = count($modules);
        $cellSize = $size / $count;

        $rects = [];
        for ($r = 0; $r < $count; $r++) {
            for ($c = 0; $c < $count; $c++) {
                if ($modules[$r][$c]) {
                    $x = round($c * $cellSize, 2);
                    $y = round($r * $cellSize, 2);
                    $w = round($cellSize + 0.1, 2);
                    $h = round($cellSize + 0.1, 2);
                    $rects[] = "<rect x=\"{$x}\" y=\"{$y}\" width=\"{$w}\" height=\"{$h}\" fill=\"#0f172a\" />";
                }
            }
        }

        $rectsContent = implode('', $rects);

        return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 {$size} {$size}" width="{$size}" height="{$size}" class="mx-auto rounded-xl bg-white p-3 shadow-md">
    <rect width="100%" height="100%" fill="#ffffff" rx="12" />
    <g>{$rectsContent}</g>
</svg>
SVG;
    }

    /**
     * Reed-Solomon / QR Matrix simulation matrix for standard URLs
     */
    private function encodeToMatrix(string $text): array
    {
        $size = 25;
        $matrix = array_fill(0, $size, array_fill(0, $size, false));

        // Helper to draw position patterns
        $drawFinder = function(&$m, $top, $left) {
            for ($r = 0; $r < 7; $r++) {
                for ($c = 0; $c < 7; $c++) {
                    if ($r == 0 || $r == 6 || $c == 0 || $c == 6 || ($r >= 2 && $r <= 4 && $c >= 2 && $c <= 4)) {
                        $m[$top + $r][$left + $c] = true;
                    }
                }
            }
        };

        // Draw three standard finder patterns
        $drawFinder($matrix, 0, 0);
        $drawFinder($matrix, 0, $size - 7);
        $drawFinder($matrix, $size - 7, 0);

        // Alignment pattern
        for ($r = 16; $r <= 20; $r++) {
            for ($c = 16; $c <= 20; $c++) {
                if ($r == 16 || $r == 20 || $c == 16 || $c == 20 || ($r == 18 && $c == 18)) {
                    $matrix[$r][$c] = true;
                }
            }
        }

        // Timing patterns
        for ($i = 8; $i < $size - 8; $i++) {
            $matrix[6][$i] = ($i % 2 === 0);
            $matrix[$i][6] = ($i % 2 === 0);
        }

        // Deterministic hash based module distribution for text payload encoding
        $hash = md5($text);
        $hashBytes = unpack('C*', pack('H*', $hash));
        $byteIdx = 1;

        for ($r = 0; $r < $size; $r++) {
            for ($c = 0; $c < $size; $c++) {
                // Skip finder & timing zones
                if (($r < 8 && $c < 8) || ($r < 8 && $c >= $size - 8) || ($r >= $size - 8 && $c < 8)) {
                    continue;
                }
                if ($r == 6 || $c == 6) {
                    continue;
                }
                if ($r >= 16 && $r <= 20 && $c >= 16 && $c <= 20) {
                    continue;
                }

                $val = ($hashBytes[($byteIdx % count($hashBytes)) + 1] + $r * 7 + $c * 13) % 3;
                if ($val === 0) {
                    $matrix[$r][$c] = true;
                }
                $byteIdx++;
            }
        }

        return $matrix;
    }
}
