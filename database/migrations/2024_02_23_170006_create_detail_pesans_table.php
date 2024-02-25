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
        Schema::create('detail_pesan', function (Blueprint $table) {
            $table->string('no_pesan', 14);
            $table->string('kd_brg', 5);
            $table->integer('qty_pesan');
            $table->integer('subtotal');
        });    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pesan');
    }
};
