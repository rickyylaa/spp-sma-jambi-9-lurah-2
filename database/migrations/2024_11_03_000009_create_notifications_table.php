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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembayaran_id')->constrained()->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained()->onDelete('cascade');
            $table->foreignId('spp_id')->constrained()->onDelete('cascade');
            $table->foreignId('wali_id')->constrained('users')->onDelete('cascade');
            $table->tinyInteger('is_read')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
