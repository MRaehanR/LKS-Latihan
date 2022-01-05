<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembelianBahanBakusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelian_bahan_bakus', function (Blueprint $table) {
            $table->id();            
            $table->date("tanggal_pembelian")->default(now());
            $table->string("bahan_baku");        
            $table->integer("jumlah");
            $table->string("supplier");
            $table->string("no_invoice");
            $table->integer("id_bahan_baku")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembelian_bahan_bakus');
    }
}
