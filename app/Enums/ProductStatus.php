<?php

namespace App\Enums;

enum ProductStatus: string
{
    case ACTIVE = 'active';
    case DAMAGED = 'damaged';
    case BORROWED = 'borrowed';
    case OUT_OF_STOCK = 'out_of_stock';
    case DISCONTINUED = 'discontinued';

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Aktif',
            self::DAMAGED => 'Rusak',
            self::BORROWED => 'Dipinjam',
            self::OUT_OF_STOCK => 'Stok Habis',
            self::DISCONTINUED => 'Tidak Diproduksi',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::ACTIVE => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/30',
            self::DAMAGED => 'bg-rose-500/10 text-rose-400 border-rose-500/30',
            self::BORROWED => 'bg-amber-500/10 text-amber-400 border-amber-500/30',
            self::OUT_OF_STOCK => 'bg-slate-500/10 text-slate-400 border-slate-500/30',
            self::DISCONTINUED => 'bg-purple-500/10 text-purple-400 border-purple-500/30',
        };
    }
}
