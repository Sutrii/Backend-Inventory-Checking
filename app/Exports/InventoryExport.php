<?php

namespace App\Exports;

use App\Models\InventoryItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InventoryExport implements FromCollection, WithHeadings
{
    /**
     * Mendapatkan koleksi data yang akan diekspor.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return InventoryItem::all()->map(function ($item) {
            return [
                'Kategori Barang' => $item->kategori_input,
                'Nama Barang' => $item->nama_barang,
                'Tipe Barang' => $item->tipe_barang,
                'Kualitas' => $item->kualitas,
                'Tanggal' => $item->tanggal,
                'Tanggal Awal Peminjaman' => $item->tanggal_awal_pinjam,
                'Tanggal Akhir Peminjaman' => $item->tanggal_akhir_pinjam,
                'Nama Peminjam' => $item->nama_peminjam,
                'Divisi Peminjam' => $item->divisi_peminjam,
                'Serial Number' => $item->sn,
                'Jumlah' => $item->jumlah,
                'Satuan' => $item->satuan,
                'Gambar' => $item->picture,
                'Keterangan' => $item->keterangan,
                'Unit Kerja' => $item->unitKerja,
                'Lokasi' => $item->lokasi,
                'Status Barang' => $item->status_barang,
                'Solusi Barang' => $item->solusi_barang,
                'Tujuan Keluar' => $item->tujuan_keluar,
            ];
        });
    }

    /**
     * Menyediakan judul kolom.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Kategori Barang',
            'Nama Barang',
            'Tipe Barang',
            'Kualitas',
            'Tanggal',
            'Tanggal Awal Peminjaman',
            'Tanggal Akhir Peminjaman',
            'Nama Peminjam',
            'Divisi Peminjam',
            'Serial Number',
            'Jumlah',
            'Satuan',
            'Gambar',
            'Keterangan',
            'Unit Kerja',
            'Lokasi',
            'Status Barang',
            'Solusi Barang',
            'Tujuan Keluar',
        ];
    }
}

