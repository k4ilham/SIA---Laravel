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
            CREATE OR REPLACE  VIEW lap_jurnal AS SELECT akun.nm_akun AS nm_akun, jurnal.tgl_jurnal AS tgl, sum(jurnal.debet) AS debet, sum(jurnal.kredit) AS kredit FROM (akun join jurnal) WHERE akun.no_akun = jurnal.no_akun GROUP BY jurnal.no_jurnal ;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP VIEW IF EXISTS lap_jurnal');
    }
};
