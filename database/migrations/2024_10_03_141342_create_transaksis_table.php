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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            // $table->string('uuid')->uniqid();
            $table->unsignedBigInteger('id_pengguna')->nullable();
            $table->foreign('id_pengguna')->references('id')->on('penggunas')->onDelete('set null');

            // $table->unsignedBigInteger('id_paketproduk')->nullable();
            $table->foreign('id_paketproduk')->references('id')->on('paket_produks')->onDelete('set null');

            $table->date("tgl_awal");
            $table->date("tgl_akhir");

            $table->integer("biaya_admin")->default(4000);
            $table->integer("total_harga");
            // $table->enum("metode", [
            //     'Bank Mandiri',
            //     'BCA',
            //     'BNI',
            //     'BRI',
            //     'BSI',
            //     'GoPay',
            //     'OVO',
            //     'DANA',
            //     'ShopeePay',
            //     'LinkAja'
            // ]);

            $table->string("metode");
            $table->string("snap_token")->nullable();


            $table->enum("status", ["Sudah bayar", "Sedang konsultasi", "Selesai", "Dibatalkan"]);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
