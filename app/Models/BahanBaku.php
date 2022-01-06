<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahanBaku extends Model
{
    use HasFactory;

    protected $fillable = ['nama_departemen', 'bahan_baku','jenis_bahan_baku', 'jumlah'];
}
