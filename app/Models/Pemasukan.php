<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemasukan extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'pemasukans';

    // Primary key dari tabel
    protected $primaryKey = 'id';

    // Kolom-kolom yang dapat diisi (fillable) secara massal
    protected $fillable = [
        'tgl_pemasukan',
        'jumlah',
        'id_sumber_pemasukan',
        'created_by', 
    ];

    public $timestamps = false;

    /**
     * Relasi dengan tabel sumber.
     * Misalnya, setiap pemasukan memiliki satu sumber.
     */
    public function sumberPemasukan()
    {
        return $this->belongsTo(SumberPemasukan::class, 'id_sumber_pemasukan', 'id');
    }

    // Menambahkan relasi dengan model User
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
