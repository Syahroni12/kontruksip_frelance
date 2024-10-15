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
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_transaksi')->nullable();
            $table->foreign('id_transaksi')->references('id')->on('transaksis')->onDelete('set null');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('penggunas')->onDelete('set null');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('penggunas')->onDelete('set null');
            $table->text('message');
            // Isi pesan
            $table->string('file')->nullable(); // Type pesan (text, image, audio, video
            $table->boolean('is_read')->default(false); // Status pesan (dibaca atau belum)
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
