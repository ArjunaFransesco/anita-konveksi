<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number', 30)->unique();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->date('tanggal_pesan');
            $table->date('deadline')->nullable();
            $table->decimal('total_harga', 15, 2)->default(0);
            $table->decimal('dp', 15, 2)->default(0);
            $table->decimal('sisa_tagihan', 15, 2)->default(0);
            $table->enum('status_produksi', [
                'nunggu_konfirmasi',
                'menunggu_bahan',
                'proses_potong',
                'proses_jahit',
                'proses_sablon_bordir',
                'quality_control',
                'siap_diambil',
                'selesai',
            ])->default('nunggu_konfirmasi');
            $table->enum('status_pembayaran', ['belum', 'lunas'])->default('belum');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
