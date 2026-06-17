<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->date('tanggal_bayar');
            $table->decimal('jumlah', 15, 2);
            $table->enum('metode', ['tunai', 'transfer'])->default('tunai');
            $table->string('bukti_transfer', 255)->nullable();
            $table->enum('tipe', ['dp', 'pelunasan'])->default('dp');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
