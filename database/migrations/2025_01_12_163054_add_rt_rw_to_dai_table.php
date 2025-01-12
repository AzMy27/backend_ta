<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRtRwToDaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dais', function (Blueprint $table) {
            $table->string('rt')->nullable()->after('alamat');
            $table->string('rw')->nullable()->after('rt');     
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dais', function (Blueprint $table) {
            $table->dropColumn(['rt', 'rw']); // Menghapus kolom 'rt' dan 'rw'
        });
    }
}
