<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('coach_sessions', function (Blueprint $table) {
            // Menandai sesi yang dibuat otomatis dari booking lapangan (bukan
            // input manual admin), supaya bisa disinkronkan/dibatalkan otomatis
            // saat status reservasi berubah.
            $table->foreignId('reservation_id')->nullable()->after('coach_id')->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('coach_sessions', function (Blueprint $table) {
            $table->dropConstrainedForeignId('reservation_id');
        });
    }
};
