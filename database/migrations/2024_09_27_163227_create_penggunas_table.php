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
        Schema::create('penggunas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('notelp');
            $table->enum('gender', ['Laki-laki', 'Perempuan']);
            $table->string('CV')->nullable();
            $table->text('alamat');
            $table->text("deskripsi")->nullable();
            $table->string('foto');
            $table->date('tgllahir');
            $table->string('no_rekening')->nullable();
            $table->enum("jenis_rekening", [
                'Bank Mandiri',
                'BCA',
                'BNI',
                'BRI',
                'BSI',
                'GoPay',
                'OVO',
                'DANA',
                'ShopeePay',
                'LinkAja'
            ]);
            $table->string('pendidikan_terakhir')->nullable();
            $table->unsignedBigInteger('id_user')->nullable();
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('id_kategori')->nullable();
            $table->foreign('id_kategori')->references('id')->on('kategori_jasas')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penggunas');
    }
};
