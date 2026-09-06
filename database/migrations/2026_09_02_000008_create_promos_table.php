<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description', 500)->nullable();
            // Nilai promo ditulis bebas sebagai teks (mis. "20%", "Rp 50rb",
            // "Gratis") supaya satu kolom bisa menampung diskon persen,
            // nominal, maupun kredit tanpa perlu tabel tipe terpisah.
            $table->string('discount_value');
            $table->string('discount_label')->default('Off');
            $table->string('icon')->default('sell');
            $table->date('valid_until')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promos');
    }
};
