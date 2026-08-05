<?php

namespace Database\Seeders;

use App\Enums\ProductStatus;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@inventory.com')->first();
        $elektronik = Category::where('name', 'Elektronik & Perangkat Komputer')->first();
        $kantor = Category::where('name', 'Peralatan Kantor')->first();
        $jaringan = Category::where('name', 'Perangkat Jaringan')->first();

        $sampleProducts = [
            [
                'code' => 'PRD-MBP-001',
                'name' => 'MacBook Pro M3 16 Inch',
                'category_id' => $elektronik?->id,
                'brand' => 'Apple',
                'serial_number' => 'SN-MBP16M3-2026',
                'location' => 'Lantai 2 - Ruang IT 01',
                'stock' => 15,
                'unit' => 'unit',
                'description' => 'Laptop inventaris tim dev & designer.',
                'specifications' => 'Apple M3 Pro, 36GB RAM, 512GB SSD, Space Black',
                'status' => ProductStatus::ACTIVE,
                'entry_date' => now()->subDays(30),
            ],
            [
                'code' => 'PRD-MON-002',
                'name' => 'Dell UltraSharp 27" 4K Monitor',
                'category_id' => $elektronik?->id,
                'brand' => 'Dell',
                'serial_number' => 'SN-DEL-U2723QE',
                'location' => 'Lantai 2 - Ruang IT 02',
                'stock' => 20,
                'unit' => 'unit',
                'description' => 'Monitor 4K IPS USB-C Hub',
                'specifications' => '4K UHD, 100% sRGB, Type-C 90W PD',
                'status' => ProductStatus::ACTIVE,
                'entry_date' => now()->subDays(20),
            ],
            [
                'code' => 'PRD-SWT-003',
                'name' => 'Cisco Catalyst 24-Port Managed Switch',
                'category_id' => $jaringan?->id,
                'brand' => 'Cisco',
                'serial_number' => 'SN-CSC-C1000-24T',
                'location' => 'Server Room - Rack A3',
                'stock' => 4,
                'unit' => 'unit',
                'description' => 'Gigabit Switch untuk infrastruktur LAN internal.',
                'specifications' => '24x GbE, 4x 1G SFP Uplink, Layer 2',
                'status' => ProductStatus::ACTIVE,
                'entry_date' => now()->subDays(15),
            ],
            [
                'code' => 'PRD-KRS-004',
                'name' => 'Ergonomic Mesh Chair Herman Miller Aeron',
                'category_id' => $kantor?->id,
                'brand' => 'Herman Miller',
                'serial_number' => 'SN-HM-AERON-B',
                'location' => 'Ruang Direksi',
                'stock' => 2,
                'unit' => 'unit',
                'description' => 'Kursi kerja ergonomis dengan dukungan lumbal.',
                'specifications' => 'Size B, PostureFit SL, Fully Adjustable Arms',
                'status' => ProductStatus::BORROWED,
                'entry_date' => now()->subDays(45),
            ],
            [
                'code' => 'PRD-PRN-005',
                'name' => 'Epson L3210 EcoTank Printer',
                'category_id' => $kantor?->id,
                'brand' => 'Epson',
                'serial_number' => 'SN-EPS-L3210-99',
                'location' => 'Lantai 1 - Admin Area',
                'stock' => 1,
                'unit' => 'unit',
                'description' => 'Printer InkTank Multifungsi Print Scan Copy',
                'specifications' => 'Print, Scan, Copy, High-Yield Ink',
                'status' => ProductStatus::DAMAGED,
                'entry_date' => now()->subDays(60),
            ],
        ];

        foreach ($sampleProducts as $data) {
            Product::updateOrCreate(
                ['code' => $data['code']],
                array_merge($data, [
                    'uuid' => (string) Str::uuid(),
                    'slug' => Str::slug($data['name']) . '-' . Str::random(4),
                    'created_by' => $admin?->id,
                    'updated_by' => $admin?->id,
                ])
            );
        }
    }
}
