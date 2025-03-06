<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStokBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stok_barangs', function (Blueprint $table) {
            $table->id(); // id auto_increment
            $table->string('kode_barang', 225); 
            $table->string('nama_barang', 225); 
            $table->string('ukuran', 225);
            $table->date('tanggal');
            $table->string('tipe'); //In / Out
            $table->integer('quantity'); // Jumlah barang yang In / Out
            $table->integer('total_stok'); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stok_barangs');
    }
}
