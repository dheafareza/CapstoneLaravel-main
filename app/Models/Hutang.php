<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hutang extends Model
{
    use HasFactory;

    /**
     * Nama tabel.
     *
     * @var string
     */
    protected $table = 'hutangs';

    /**
     * Primary key tabel.
     *
     * @var string
     */
    protected $primaryKey = 'id_hutang';

    /**
     * Menentukan apakah primary key menggunakan auto-increment.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * Tipe data primary key.
     *
     * @var string
     */
    protected $keyType = 'int';

    /**
     * Kolom-kolom yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = ['jumlah', 'tgl_hutang', 'alasan', 'penghutang', 'keterangan', 'status'];


    /**
     * Menentukan apakah tabel menggunakan kolom timestamps.
     *
     * @var bool
     */
    public $timestamps = true;
}
