<?php

namespace Database\Seeders;

use App\Models\Court;
use Illuminate\Database\Seeder;

class CourtSeeder extends Seeder
{
    public function run(): void
    {
        Court::firstOrCreate(
            ['slug' => 'mawar'],
            [
                'nama' => 'Lapangan Mawar',
                'lokasi' => 'Area Timur (Outdoor)',
                'tipe' => 'Outdoor Premium',
                'harga' => 350000,
                'harga_coret' => null,
                'deskripsi' => 'Lapangan outdoor kami menawarkan udara terbuka dengan turf biru premium dan taman asri di sekelilingnya, cocok untuk bermain di pagi hingga sore hari dengan pencahayaan alami yang optimal.',
                'gambar_utama' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDrGjyHVITMi3pNVnqY3tfI70vNLJjBdCKdv2K_MvOwGt3IQ4pUP5LXoJgKnM4y5zFocBSIL0-1y5kkAgYeoKj8lH3b2eNtHFFFELMjbl-rlCg0psFZa0O9_prx1JCSs5CVRRtLObXDU23Ob5SRBxmQruu1YmrDQLFuwenkF9Gu8HW82nwn3uKVVOgYGl5Vxc-pTWLqLtfzXmZe_3gW5T07KdX0E7S2hqqa83M3hVBfbQW0C6mouI8Ylg',
                'slot' => ['08:00', '10:00', '15:00', '17:00', '20:00'],
                'status' => 'tersedia',
                'status_catatan' => null,
                'is_active' => true,
                'urutan' => 1,
            ]
        );

        Court::firstOrCreate(
            ['slug' => 'melati'],
            [
                'nama' => 'Lapangan Melati',
                'lokasi' => 'Area Barat (Indoor)',
                'tipe' => 'Indoor Terbuka',
                'harga' => 450000,
                'harga_coret' => null,
                'deskripsi' => 'Lapangan indoor dengan langit-langit tinggi dan pencahayaan arsitektural yang canggih. Permukaan hijau premium berpadu dengan dinding putih minimalis dan aksen kuningan, memberi suasana tenang dan eksklusif sepanjang hari.',
                'gambar_utama' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCMBxgiERz_Y51MoC0mpC_-z4lG0T2kELjdJ0YwjSkZOnmlz0dTiChGQLKnxkx6KhR5uV_WTpgs1MS4z5MDZMrlvhZu02iug4fEXmxvZEQEiHjUHj9P4wN2xJwCqVg8Od-vCId0xvq6QWvIeV46U8wUaoirUFCKmnfXpIP3uinLxp1_8s2M_jEP2JdoUirURNiGkEId7-1lvCU0_ZFRGtR9UYTcGq7M-U_XoZLpJ1hEnxhrzYDcyMeOEg',
                'slot' => ['08:00', '10:30', '13:00', '19:00'],
                'status' => 'tersedia',
                'status_catatan' => null,
                'is_active' => true,
                'urutan' => 2,
            ]
        );

        Court::firstOrCreate(
            ['slug' => 'anggrek'],
            [
                'nama' => 'Lapangan Anggrek',
                'lokasi' => 'Area Tengah (Semi-Outdoor)',
                'tipe' => 'Semi-Outdoor',
                'harga' => 320000,
                'harga_coret' => 400000,
                'deskripsi' => 'Lapangan semi-outdoor dengan nuansa golden hour sepanjang hari berkat elemen arsitektur blush pink dan vegetasi hijau di sekelilingnya. Sedang ada promo diskon 20% untuk waktu terbatas.',
                'gambar_utama' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDi5oxMbICWrvRVmhUx0EVWWimvfXFhaV06TMl4FB6onQIdHJlIFV9WuIw2vYiWKRIeItOQsTkXQpoWG7iU60POt4esj7VVcANqHFg2-oYouoJZ9IX6KkhK2EzZQ7JCay1PzfhQC5Zv8rGHJLBshIT3Q2xq1FMIy7l5yOyE03XAK2a5cvd8X7D4yzsFIZjppdRxj2LILKiSBJJS0R7rOcD9gDYCMi5wwLDedhPwIgEGazTuigvusvooZw',
                'slot' => ['12:00', '16:00', '18:30', '21:00'],
                'status' => 'pemeliharaan',
                'status_catatan' => 'Pembersihan kaca & perataan pasir',
                'is_active' => true,
                'urutan' => 3,
            ]
        );

        Court::firstOrCreate(
            ['slug' => 'dahlia'],
            [
                'nama' => 'Lapangan Dahlia',
                'lokasi' => 'Area Utara (Outdoor)',
                'tipe' => 'Outdoor Standard',
                'harga' => 300000,
                'harga_coret' => null,
                'deskripsi' => 'Lapangan outdoor standar dengan turf hijau dan pagar keliling, pilihan hemat untuk sesi latihan santai bersama teman.',
                'gambar_utama' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBV2h8xXkxYeto5NoYqmY09CD4sxvF7kwQ6BG3qnbc2Eezcqu2UwvRm3aWuhWX7jepz6xcVPiN2dk8LxEq0naDz9YULyWEcKPyU64258c4Bg5WwXY8sFHZsqKwscXURAsuA9Kzo_uG-W4sxx8npmn__rb-dIKGk3745T5muL6hbseqmanH4MPHTnRnPANabZJzh_Tw8M98la-j79O5byttX2bkWs46BsMrIFrgKbkGblyCfnQQK0nYiSQ',
                'slot' => ['09:00', '11:00', '14:00', '16:00', '19:00'],
                'status' => 'tersedia',
                'status_catatan' => null,
                'is_active' => true,
                'urutan' => 4,
            ]
        );
    }
}
