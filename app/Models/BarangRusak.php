<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangRusak extends Model
{
    use HasFactory;
    protected $table = 'barang_rusak';
    protected $fillable = [
        'nama_barang',
        'tipe_barang',
        'kualitas',
        'tanggal',
        'sn',
        'jumlah',
        'satuan',
        'keterangan',
        'lokasi',
        'picture',
        'work_unit',
    ];
}
