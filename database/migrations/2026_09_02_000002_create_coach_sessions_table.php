<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coach_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coach_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['privat', 'akademi', 'istirahat'])->default('privat');
            $table->string('title');
            $table->date('session_date');
            $table->string('start_time', 5); // format "HH:MM", 24 jam
            $table->string('end_time', 5);
            $table->string('location')->nullable();
            $table->string('notes')->nullable();
            $table->timestamps();

            $table->index(['coach_id', 'session_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coach_sessions');
    }
};
