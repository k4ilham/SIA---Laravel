<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';

    public $timestamps = false;

    protected $fillable = [
        'kd_brg',
        'nm_brg',
        'harga',
        'stok'
    ];
}
