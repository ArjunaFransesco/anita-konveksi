<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('order_detail_logos')) {
            Schema::create('order_detail_logos', function (Blueprint $table) {
                $table->id();
                $table->foreignId('order_detail_id')->constrained('order_details')->onDelete('cascade');
                $table->string('logo_path', 255)->nullable();
                $table->text('keterangan_desain')->nullable();
                $table->timestamps();
            });
        }

        // Salin data lama dari order_details.logo_path/desain agar data lama tetap tampil
        // di fitur multi logo yang baru.
        DB::table('order_details')
            ->where(function ($query) {
                $query->whereNotNull('logo_path')
                    ->orWhereNotNull('desain');
            })
            ->orderBy('id')
            ->get()
            ->each(function ($detail) {
                $exists = DB::table('order_detail_logos')
                    ->where('order_detail_id', $detail->id)
                    ->where('logo_path', $detail->logo_path)
                    ->where('keterangan_desain', $detail->desain)
                    ->exists();

                if (!$exists) {
                    DB::table('order_detail_logos')->insert([
                        'order_detail_id' => $detail->id,
                        'logo_path' => $detail->logo_path,
                        'keterangan_desain' => $detail->desain,
                        'created_at' => $detail->created_at ?? now(),
                        'updated_at' => $detail->updated_at ?? now(),
                    ]);
                }
            });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_detail_logos');
    }
};
