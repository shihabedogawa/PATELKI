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
    Schema::create('board_members', function (Blueprint $table) {
        $table->id();

        $table->foreignId('member_id')
              ->constrained('members')
              ->cascadeOnDelete();

        $table->foreignId('position_id')
              ->constrained('positions')
              ->cascadeOnDelete();

        $table->year('period_start');
        $table->year('period_end')->nullable();
        $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('board_members');
    }
};
