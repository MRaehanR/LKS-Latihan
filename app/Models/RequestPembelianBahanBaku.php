<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestPembelianBahanBaku extends Model
{
    use HasFactory;

    protected $fillable = ['no_request', 'bahan_baku', 'jumlah', 'supplier', 'departemen'];
}
