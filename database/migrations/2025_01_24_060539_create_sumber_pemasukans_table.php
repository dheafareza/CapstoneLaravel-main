<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSumberPemasukansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sumber_pemasukans', function (Blueprint $table) {
            $table->id(); // Default ke unsignedBigInteger
            $table->string('nama', 40); // Nama sumber pemasukan
            $table->timestamps(); // Timestamps (created_at & updated_at)
        });
        
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sumber_pemasukans');
    }
}