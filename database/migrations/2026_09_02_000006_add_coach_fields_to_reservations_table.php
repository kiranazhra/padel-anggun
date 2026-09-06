<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            // Nullable: pelatih bersifat opsional saat booking. coach_nama dan
            // coach_fee disimpan sebagai snapshot (sama seperti court_nama),
            // supaya riwayat reservasi tetap akurat walau data pelatih berubah.
            $table->foreignId('coach_id')->nullable()->after('court_nama')->constrained()->nullOnDelete();
            $table->string('coach_nama')->nullable()->after('coach_id');
            $table->unsignedInteger('coach_fee')->default(0)->after('coach_nama');
        });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropConstrainedForeignId('coach_id');
            $table->dropColumn(['coach_nama', 'coach_fee']);
        });
    }
};
