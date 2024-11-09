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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('place');
            $table->date('date');
            $table->text('description');
            $table->text('images');
            $table->foreignId('dai_id');
            $table->text('koreksi_desa');
            $table->enum('validasi_desa',['diterima','ditolak']);
            $table->text('koreksi_kecamatan');
            $table->enum('validasi_kecamatan',['diterima','ditolak']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
