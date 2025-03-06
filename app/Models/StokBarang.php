<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokBarang extends Model
{
    use HasFactory;

    protected $table = 'stok_barangs';

    // Primary Key
    protected $primaryKey = 'id';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'ukuran',
        'tanggal',
        'tipe',
        'quantity',
        'total_stok',
    ];

    public $timestamps = true;

}
