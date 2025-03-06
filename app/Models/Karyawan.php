<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'karyawans';

    // Primary key
    protected $primaryKey = 'id';

    // Kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'nama', 
        'jabatan', 
        'umur',
        'email', 
        'no_telp', 
        'alamat',
    ];

    public $timestamps = false;

}