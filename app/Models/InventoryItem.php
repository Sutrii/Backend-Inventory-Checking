<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    use HasFactory;
    protected $table = 'inventory_item';
    protected $fillable = [
        'kategori_barang',
        'nama_barang',
        'tipe_barang',
        'kualitas',
        'tanggal',
        'tanggal_awal_pinjaman',
        'tanggal_akhir_pinjaman',
        'sn',
        'jumlah',
        'satuan',
        'keterangan',
        'lokasi',
        'picture',
        'work_unit',
    ];
}
