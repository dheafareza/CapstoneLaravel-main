<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SumberPemasukan extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'sumber_pemasukans';

    // Primary key
    protected $primaryKey = 'id';

    protected $fillable = ['nama'];

    public $timestamps = true;

    public function pemasukans()
    {
        return $this->hasMany(Pemasukan::class, 'id_sumber_pemasukan', 'id');
    }
}
