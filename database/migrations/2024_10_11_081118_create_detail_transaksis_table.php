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
        Schema::create('detail_transaksis', function (Blueprint $table) {
            $table->id();
            $table->string("produk");
            $table->string("paket");
            $table->integer("lama_hari");
            $table->text("deskripsi");
            $table->integer("harga")->default(0);
            $table->string("gambar")->nullable();
            $table->unsignedBigInteger("id_kategori")->default(0);

            $table->unsignedBigInteger('id_owner');
            $table->foreign('id_owner')->references('id')->on('penggunas')->onDelete('cascade');
            $table->unsignedBigInteger('id_transaksi')->nullable();
            $table->foreign('id_transaksi')->references('id')->on('transaksis')->onDelete('cascade');
            $table->foreign('id_kategori')->references('id')->on('kategori_jasas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksis');
    }
};
