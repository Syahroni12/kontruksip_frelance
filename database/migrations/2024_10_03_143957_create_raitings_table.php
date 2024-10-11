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
        Schema::create('raitings', function (Blueprint $table) {
            $table->id();
            $table->text("ulasan");
            $table->integer("rating");
            $table->string("file")->nullable();
            $table->unsignedBigInteger('id_transaksi')->nullable();
            $table->foreign('id_transaksi')->references('id')->on('transaksis')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raitings');
    }
};
