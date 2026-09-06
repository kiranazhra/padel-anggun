<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('coaches', function (Blueprint $table) {
            // Biaya sesi coaching yang ditambahkan sebagai add-on saat member
            // memesan lapangan dan memilih pelatih.
            $table->unsignedInteger('fee')->default(150000)->after('specialty');
        });
    }

    public function down(): void
    {
        Schema::table('coaches', function (Blueprint $table) {
            $table->dropColumn('fee');
        });
    }
};
