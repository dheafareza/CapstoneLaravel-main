<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SumberPemasukanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sumber_pemasukans')->insert([
            ['nama' => 'Boutique 1'],
            ['nama' => 'Boutique 2'],
        ]);
    }
}
