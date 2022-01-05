<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestPembelianBahanBakusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_pembelian_bahan_bakus', function (Blueprint $table) {
            $table->id();
            $table->string("no_request");
            $table->string("bahan_baku");
            $table->integer("jumlah");
            $table->string("supplier");
            $table->string("departemen");
            $table->timestamp("order_at");
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
        Schema::dropIfExists('request_pembelian_bahan_bakus');
    }
}
