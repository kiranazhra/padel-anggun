<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('court_slug');          // mawar | melati | anggrek
            $table->string('court_nama');           // "Lapangan Mawar"
            $table->string('lokasi')->nullable();   // "Area Timur (Outdoor)"
            $table->string('nama_pemesan')->default('Isabella'); // demo: belum ada sistem login/user sungguhan
            $table->date('tanggal');
            $table->string('waktu');                // "14:00 - 15:30"
            $table->unsignedInteger('total_harga')->default(0);
            $table->string('status')->default('menunggu_konfirmasi'); // menunggu_konfirmasi | terkonfirmasi | dibatalkan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
