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
        Schema::create('reporttes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dai_id');
            $table->string('judul');
            $table->string('lokasi');
            $table->date('tanggal');
            $table->string('keterangan');
            $table->string('gambar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reporttes');
    }
};
