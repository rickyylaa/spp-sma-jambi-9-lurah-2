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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->string('invoice')->unique();
            $table->foreignId('siswa_id')->constrained()->onDelete('cascade');
            $table->foreignId('spp_id')->constrained()->onDelete('cascade');
            $table->string('metode_pembayaran', 20)->default('cash');
            $table->string('untuk_bulan', 16);
            // $table->integer('tahun');
            $table->integer('jumlah');
            $table->string('bukti')->nullable();
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['pending', 'diterima', 'ditolak']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
