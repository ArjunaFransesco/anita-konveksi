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
        Schema::create('penggajians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('bulan', 7); // Format: YYYY-MM
            $table->integer('minggu_ke')->nullable(); // 1-5, null jika bulanan
            $table->decimal('hari_kerja', 5, 2)->default(0); // bisa 5.5 hari dsb
            $table->decimal('total_gaji', 15, 2);
            $table->enum('status', ['pending', 'dibayar'])->default('pending');
            $table->date('tanggal_bayar')->nullable();
            $table->timestamps();

            // Memastikan satu pegawai hanya punya 1 record gaji di periode minggu yg sama dalam satu bulan
            $table->unique(['employee_id', 'bulan', 'minggu_ke']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penggajians');
    }
};
