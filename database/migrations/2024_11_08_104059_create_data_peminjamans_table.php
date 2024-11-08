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
        Schema::create('data_peminjamans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('mobil_id');
            $table->foreign('mobil_id')->references('id')->on('data_mobils')->onDelete('cascade');
            $table->date('tanggal_peminjaman');
            $table->date('tanggal_pengembalian');
            $table->decimal('nominal_pembayaran', 13,2);
            $table->unsignedBigInteger('metode_pembayaran_id');
            $table->foreign('metode_pembayaran_id')->references('id')->on('metode_pembayarans')->onDelete('cascade');
            $table->enum('status_pembayaran', ['Paid', 'Unpaid'])->default('Unpaid');
            $table->enum('status_verifikasi', ['Verified', 'Unverified'])->default('Unverified');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_peminjamans');
    }
};
