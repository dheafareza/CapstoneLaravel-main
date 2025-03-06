<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'pengeluarans';

    // Primary key dari tabel
    protected $primaryKey = 'id';

    // Kolom-kolom yang dapat diisi (fillable) secara massal
    protected $fillable = [
        'tgl_pengeluaran',
        'jumlah',
        'id_sumber_pengeluaran',
    ];

    public $timestamps = true;

    /**
     * Relasi dengan tabel sumber_pengeluarans.
     * Setiap pengeluaran memiliki satu sumber_pengeluaran.
     */
    public function sumberPengeluaran()
    {
        return $this->belongsTo(SumberPengeluaran::class, 'id_sumber_pengeluaran', 'id');
    }
}
