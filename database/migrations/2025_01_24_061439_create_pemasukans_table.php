<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemasukansTable extends Migration
{
    public function up()
    {
        Schema::create('pemasukans', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->date('tgl_pemasukan');
            $table->integer('jumlah'); // Jumlah pemasukan
            $table->unsignedBigInteger('id_sumber_pemasukan'); // Foreign key ke tabel sumber_pemasukans
            $table->foreign('id_sumber_pemasukan')
                  ->references('id')
                  ->on('sumber_pemasukans')
                  ->onDelete('cascade'); // Referential integrity
            $table->timestamps();
        });
        
        
    }

    public function down()
    {
        Schema::dropIfExists('pemasukans');
    }
}
