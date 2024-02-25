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
            CREATE TRIGGER update_stok after INSERT ON detail_pembelian
            FOR EACH ROW BEGIN
                UPDATE barang
                    SET stok = stok + NEW.qty_beli
                WHERE
                    kd_brg = NEW.kd_brg;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER update_stok');
    }
};
