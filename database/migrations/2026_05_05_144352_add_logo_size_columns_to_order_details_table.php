<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('order_details', function (Blueprint $table) {
            if (!Schema::hasColumn('order_details', 'logo_path')) {
                $table->string('logo_path', 255)->nullable()->after('desain');
            }
            if (!Schema::hasColumn('order_details', 'size_id')) {
                $table->foreignId('size_id')->nullable()->constrained('sizes')->nullOnDelete();
            }
            if (!Schema::hasColumn('order_details', 'size_custom')) {
                $table->string('size_custom', 20)->nullable()->after('size_id');
            }
        });
    }

    public function down()
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->dropForeign(['size_id']);
            $table->dropColumn(['logo_path', 'size_id', 'size_custom']);
        });
    }
};