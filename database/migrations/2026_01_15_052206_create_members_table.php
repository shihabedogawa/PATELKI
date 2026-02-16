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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('nap')->nullable()->unique();
            $table->string('phone')->nullable();
            $table->date('birthdate');
            $table->enum('gender',['male','female']);

            $table->string('diploma_number');
            $table->string('str_number')->unique();

            // STATUS UNTUK VALIDASI
            $table->enum('status',['pending','approved','rejected'])
                ->default('pending');

            $table->date('joined_at')->nullable();

            // file upload
            $table->string('ijazah_file')->nullable();
            $table->string('str_file')->nullable();
            $table->string('foto_file')->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
