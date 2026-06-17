// database/migrations/xxxx_xx_xx_add_logo_and_size_to_order_details_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->string('logo_path', 255)->nullable()->after('desain');
            $table->foreignId('size_id')->nullable()->constrained('sizes')->nullOnDelete();
            $table->string('size_custom', 20)->nullable()->after('size_id');
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