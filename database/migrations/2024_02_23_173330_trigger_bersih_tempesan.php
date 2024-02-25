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
        CREATE TRIGGER clear_tem_pesan AFTER INSERT ON detail_pesan
        FOR EACH ROW 
        BEGIN
            DELETE FROM temp_pemesanan;
        END
        ');   
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER clear_tem_pesan');
    }
};
