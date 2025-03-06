<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKaryawansTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id(); // Primary key auto increment
            $table->string('nama', 255); 
            $table->string('jabatan', 255); 
            $table->integer('umur');
            $table->string('email', 255)->unique();
            $table->string('no_telp', 15); 
            $table->text('alamat'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
}