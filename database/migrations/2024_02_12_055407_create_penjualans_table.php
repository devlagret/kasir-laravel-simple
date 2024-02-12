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
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id('PenjualanID');
            $table->date('TanggalPenjualan')->nullable();
            $table->decimal('TotalHarga',10)->nullable();
            $table->unsignedBigInteger('PelangganID')->nullable();
            $table->foreign('PelangganID')->on('pelanggan')->references('PelangganID')->onUpdate('cascade')->onDelete('set null');
            $table->timestamps();
            $table->softDeletesTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan');
    }
};
