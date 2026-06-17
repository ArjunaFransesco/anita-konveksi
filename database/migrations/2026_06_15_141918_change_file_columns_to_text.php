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
        Schema::table('payments', function (Blueprint $table) {
            $table->text('bukti_transfer')->nullable()->change();
        });

        Schema::table('pengeluarans', function (Blueprint $table) {
            $table->text('foto_nota')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('bukti_transfer', 255)->nullable()->change();
        });

        Schema::table('pengeluarans', function (Blueprint $table) {
            $table->string('foto_nota', 255)->nullable()->change();
        });
    }
};
