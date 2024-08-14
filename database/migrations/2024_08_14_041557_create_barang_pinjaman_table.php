<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangPinjamanTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('barang_pinjaman', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->string('tipe_barang');
            $table->string('kualitas');
            $table->date('tanggal');
            $table->string('sn')->unique();
            $table->integer('jumlah');
            $table->string('satuan');
            $table->string('picture')->nullable(); 
            $table->text('keterangan')->nullable();
            $table->text('work_unit');
            $table->string('lokasi'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * 
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang_pinjaman');
    }
};
