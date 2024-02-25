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
        Schema::create('detail_retur', function (Blueprint $table) {
            $table->string('no_retur',14);
            $table->string('kd_brg',5);
            $table->integer('qty_retur');
            $table->integer('sub_retur');
        });   
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_retur');
    }
};
