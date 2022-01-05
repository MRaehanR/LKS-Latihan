<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianBahanBaku extends Model
{
    use HasFactory;

    protected $fillable = ['bahan_baku', 'jumlah', 'supplier', 'no_invoice', 'id_bahan_baku'];
}
