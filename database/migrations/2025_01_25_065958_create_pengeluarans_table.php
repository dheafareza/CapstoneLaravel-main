<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengeluaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengeluarans', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->date('tgl_pengeluaran');
            $table->integer('jumlah'); // Jumlah pengeluaran
            $table->unsignedBigInteger('id_sumber_pengeluaran'); // Foreign key ke tabel sumber_pengeluarans
            $table->timestamps();

            // Foreign key constraint
            $table
                ->foreign('id_sumber_pengeluaran')
                ->references('id')
                ->on('sumber_pengeluarans')
                ->onDelete('cascade'); // Menghapus data pengeluaran jika sumbernya dihapus
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengeluarans');
    }
}
