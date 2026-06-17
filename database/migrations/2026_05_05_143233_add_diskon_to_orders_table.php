<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'diskon_persen')) {
                $table->decimal('diskon_persen', 5, 2)->default(0)->after('total_harga');
            }
            if (!Schema::hasColumn('orders', 'total_setelah_diskon')) {
                $table->decimal('total_setelah_diskon', 15, 2)->default(0)->after('diskon_persen');
            }
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['diskon_persen', 'total_setelah_diskon']);
        });
    }
};