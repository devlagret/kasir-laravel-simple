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
        Schema::create('detailpenjualan', function (Blueprint $table) {
            $table->id('DetailID');
            $table->unsignedBigInteger('PenjualanID')->nullable();
            $table->foreign('PenjualanID')->on('penjualan')->references('PenjualanID')->onUpdate('cascade')->onDelete('set null');
            $table->unsignedBigInteger('ProdukID')->nullable();
            $table->foreign('ProdukID')->on('produk')->references('ProdukID')->onUpdate('cascade')->onDelete('set null');
            $table->integer('JumlahProduk')->nullable();
            $table->decimal('Subtotal',10)->nullable();
            $table->timestamps();
            $table->softDeletesTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detailpenjualan');
    }
};
