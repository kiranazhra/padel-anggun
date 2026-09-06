<?php

namespace Database\Seeders;

use App\Models\Promo;
use Illuminate\Database\Seeder;

class PromoSeeder extends Seeder
{
    public function run(): void
    {
        Promo::firstOrCreate(
            ['title' => 'Diskon Pagi Hari'],
            [
                'description' => 'Berlaku untuk pemesanan lapangan antara pukul 06:00 - 09:00 WIB di hari kerja.',
                'discount_value' => '20%',
                'discount_label' => 'Off',
                'icon' => 'wb_sunny',
                'valid_until' => null,
                'is_active' => true,
            ]
        );

        Promo::firstOrCreate(
            ['title' => 'Member Baru'],
            [
                'description' => 'Kredit tambahan otomatis untuk setiap pendaftaran keanggotaan tahunan baru.',
                'discount_value' => 'Rp 50rb',
                'discount_label' => 'Kredit',
                'icon' => 'card_membership',
                'valid_until' => null,
                'is_active' => true,
            ]
        );
    }
}
