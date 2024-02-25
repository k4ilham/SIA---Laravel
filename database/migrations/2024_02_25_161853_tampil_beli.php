<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
            CREATE VIEW tampil_pembelian AS (select barang.kd_brg AS kd_brg,detail_pembelian.no_beli AS no_beli,barang.nm_brg AS nm_brg,barang.harga AS harga,detail_pembelian.qty_beli AS qty_beli from (barang join detail_pembelian) where barang.kd_brg = detail_pembelian.kd_brg) ;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP VIEW IF EXISTS tampil_pembelian');
    }
};
