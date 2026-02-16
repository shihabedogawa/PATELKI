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
        Schema::create('dues_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('amount');          // nominal iuran
            $table->string('start_month');      // contoh: "Januari"
            $table->year('start_year');         // contoh: 2026
            $table->text('note')->nullable();   // alasan perubahan
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dues_settings');
    }
};
