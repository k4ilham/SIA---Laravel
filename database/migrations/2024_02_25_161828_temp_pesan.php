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
            CREATE OR REPLACE VIEW temp_pesan AS
            SELECT 
                tp.kd_brg AS kd_brg,
                CONCAT(b.nm_brg, "", b.harga) AS nm_brg,
                tp.qty_pesan AS qty_pesan,
                (b.harga * tp.qty_pesan) AS subtotal
            FROM temp_pemesanan tp
            JOIN barang b ON tp.kd_brg = b.kd_brg;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP VIEW IF EXISTS temp_pesan');
    }
};
