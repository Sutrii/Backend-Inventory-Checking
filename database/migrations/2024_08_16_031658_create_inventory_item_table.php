<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('inventory_item', function (Blueprint $table) {
            $table->id();
            $table->string('kategori_input');
            $table->string('nama_barang');
            $table->string('tipe_barang');
            $table->string('kualitas');
            $table->date('tanggal')->nullable();
            $table->date('tanggal_awal_pinjam')->nullable();
            $table->date('tanggal_akhir_pinjam')->nullable();
            $table->string('nama_peminjam')->nullable();
            $table->string('divisi_peminjam')->nullable();
            $table->string('status_barang')->nullable();
            $table->string('solusi_barang')->nullable();
            $table->string('tujuan_keluar')->nullable();
            $table->string('sn')->unique();
            $table->integer('jumlah');
            $table->string('satuan');
            $table->string('picture')->nullable();
            $table->json('bukti')->nullable(); 
            $table->text('keterangan')->nullable();
            $table->text('work_unit');
            $table->string('lokasi'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_item');
    }
};
