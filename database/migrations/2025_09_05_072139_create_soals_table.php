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
        Schema::create('soals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_ujian_id')->constrained('jadwal_ujians')->onDelete('cascade');
            $table->text('pertanyaan');
            $table->string('opsi_a');
            $table->string('opsi_b');
            $table->string('opsi_c');
            $table->string('opsi_d');
            $table->string('jawaban_benar'); // A/B/C/D
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soals');
    }
};
