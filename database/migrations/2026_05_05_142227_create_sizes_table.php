<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('sizes')) {
            Schema::create('sizes', function (Blueprint $table) {
                $table->id();
                $table->string('name', 20)->unique();
                $table->timestamps();
            });
        }

        // Insert default sizes (hanya jika tabel baru saja dibuat atau kosong)
        if (DB::table('sizes')->count() == 0) {
            $sizes = ['S', 'M', 'L', 'XL', 'XXL', 'XXXL'];
            foreach ($sizes as $size) {
                DB::table('sizes')->insert(['name' => $size, 'created_at' => now()]);
            }
        }
    }

    public function down()
    {
        Schema::dropIfExists('sizes');
    }
};