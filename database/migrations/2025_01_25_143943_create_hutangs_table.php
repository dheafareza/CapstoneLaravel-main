<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHutangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hutangs', function (Blueprint $table) {
            $table->id('id_hutang'); // Primary Key
            $table->integer('jumlah'); // Jumlah hutang
            $table->date('tgl_hutang');
            $table->text('alasan');
            $table->string('penghutang', 40);
            $table->text('keterangan');
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
        Schema::dropIfExists('hutangs');
    }
}
