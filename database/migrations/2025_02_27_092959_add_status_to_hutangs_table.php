<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('hutangs', function (Blueprint $table) {
        $table->string('status')->default('belum lunas'); // Default hutang belum lunas
    });
}

public function down()
{
    Schema::table('hutangs', function (Blueprint $table) {
        $table->dropColumn('status');
    });
}

};
