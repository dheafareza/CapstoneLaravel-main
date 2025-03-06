<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\SumberPengeluaran;

class SumberPengeluaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Data default untuk tabel sumber_pengeluarans
        DB::table('sumber_pengeluarans')->insert([
            ['nama' => 'Listrik'],
            ['nama' => 'Air'],
            ['nama' => 'Gaji Karyawan'],
            ['nama' => 'Sewa Tempat'],
            ['nama' => 'Transportasi'],
        ]);
    }
}
