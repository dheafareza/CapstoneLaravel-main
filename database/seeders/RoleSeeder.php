<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run()
    {
        DB::table('roles')->delete(); 

        DB::statement('ALTER TABLE roles AUTO_INCREMENT = 1');

        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'Owner'],
            ['id' => 2, 'name' => 'Admin Keuangan'],
            ['id' => 3, 'name' => 'Admin Stok Barang'],
            ['id' => 4, 'name' => 'Management'],
        ]);
    }
}
