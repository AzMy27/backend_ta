<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('desas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kecamatan_id');
            $table->string('nama_desa');
            $table->string('nama_kepala');
            $table->string('no_telp_desa');
            $table->foreignId('user_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('desas');
    }
};
