<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('slug')->unique();

            $table->text('description');

            // file
            $table->string('cover_image');      // foto utama
            $table->string('report_file')->nullable(); // pdf laporan

            // tipe konten
            $table->enum('type', ['news', 'baksos']);

            // khusus event/baksos
            $table->date('event_date')->nullable();

            // status
            $table->boolean('is_published')->default(false);

            // relasi ke user (admin humas)
            $table->foreignId('created_by')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
