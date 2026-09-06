<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $fillable = [
        'title',
        'description',
        'discount_value',
        'discount_label',
        'icon',
        'valid_until',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'valid_until' => 'date',
            'is_active' => 'boolean',
        ];
    }

    /**
     * True kalau promo sudah lewat tanggal berlakunya. Promo yang expired
     * tetap ditampilkan sebagai riwayat, tapi ditandai berbeda dari yang
     * benar-benar sedang non-aktifkan manual oleh admin.
     */
    protected function isExpired(): Attribute
    {
        return Attribute::get(fn () => $this->valid_until && $this->valid_until->isPast());
    }
}
