<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BarangPinjaman extends Model
{
    use HasFactory;

    protected $table = 'barang_pinjaman';

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
        'tanggal_akhir_pinjam', // Ensure this is added
        'kategori_input' // Ensure this is added
    ];

    // Add a dynamic attribute for "Sisa Masa Pinjaman"
    protected $appends = ['sisa_masa_pinjaman'];

    public function getSisaMasaPinjamanAttribute()
    {
        $endDate = Carbon::parse($this->tanggal_akhir_pinjam);
        $now = Carbon::now();
        $daysLeft = $endDate->diffInDays($now, false);
        return $daysLeft > 0 ? $daysLeft . ' Hari' : 'Habis';
    }
}
