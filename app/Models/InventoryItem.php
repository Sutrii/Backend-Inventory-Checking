<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    use HasFactory;
    protected $table = 'inventory_item';
    protected $fillable = [
        'kategori_input',
        'nama_barang',
        'tipe_barang',
        'kualitas',
        'tanggal',
        'tanggal_awal_pinjam',
        'tanggal_akhir_pinjam',
        'divisi_peminjam',
        'nama_peminjam',
        'tujuan_keluar',
        'sn',
        'jumlah',
        'satuan',
        'keterangan',
        'lokasi',
        'picture',
        'bukti',
        'work_unit',
        'status_barang',
        'solusi_barang'
    ];
}
