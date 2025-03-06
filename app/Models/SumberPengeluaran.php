<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SumberPengeluaran extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'sumber_pengeluarans';

    // Primary key
    protected $primaryKey = 'id';

    protected $fillable = [
        'nama',
    ];

    public $timestamps = true;

    /**
     * Relasi ke tabel lain.
     */
    public function pengeluarans()
    {
        return $this->hasMany(Pengeluaran::class, 'id_sumber_pengeluaran', 'id');
    }
}
