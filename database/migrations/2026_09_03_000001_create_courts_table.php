<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courts', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(); // dipakai di URL: /lapangan dan /reservasi/{court}
            $table->string('nama');
            $table->string('lokasi')->nullable();
            $table->string('tipe')->nullable();
            $table->unsignedInteger('harga')->default(0);
            $table->unsignedInteger('harga_coret')->nullable(); // harga sebelum diskon, kalau ada promo
            $table->string('deskripsi', 1000)->nullable();
            // text (bukan string/VARCHAR 255) karena URL gambar bisa lebih
            // dari 255 karakter — VARCHAR 255 di MySQL akan menolak data
            // yang lebih panjang (beda dengan SQLite yang tidak strict).
            $table->text('gambar_utama')->nullable();
            // Jam-jam slot yang bisa dipesan pelanggan, mis. ["08:00", "10:00", ...]
            $table->json('slot')->nullable();
            // Status operasional harian yang dikelola admin dari panel Kelola Lapangan.
            $table->string('status')->default('tersedia'); // tersedia | digunakan | pemeliharaan
            $table->string('status_catatan')->nullable(); // mis. "Andi S. & Tim" atau "Pembersihan kaca & perataan pasir"
            // Kalau non-aktif, lapangan tidak ditampilkan/tidak bisa dipesan di halaman customer,
            // tapi datanya tetap tersimpan (bukan dihapus) supaya riwayat reservasi lama tetap utuh.
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courts');
    }
};
