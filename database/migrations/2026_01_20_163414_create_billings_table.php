<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('billings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->cascadeOnDelete();
            $table->string('bulan');          // Januari, Februari, dll
            $table->year('tahun');
            $table->integer('amount');        // 50000
            $table->enum('status', [
                'unpaid',      // belum lunas
                'waiting',     // menunggu verifikasi
                'paid',        // sudah lunas
                'rejected'     // ditolak
            ])->default('unpaid');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billings');
    }
};
