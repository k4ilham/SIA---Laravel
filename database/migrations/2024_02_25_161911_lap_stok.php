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
           CREATE OR REPLACE  VIEW lap_stok AS (select barang.kd_brg AS kd_brg,barang.nm_brg AS nm_brg,barang.harga AS harga,barang.stok AS stok,sum(detail_pembelian.qty_beli) AS beli,sum(detail_retur.qty_retur) AS retur from ((barang join detail_retur) join detail_pembelian) where barang.kd_brg = detail_retur.kd_brg and barang.kd_brg = detail_pembelian.kd_brg group by barang.kd_brg) ;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP VIEW IF EXISTS lap_stok');
    }
};
