<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('inventory', function (Blueprint $table) {
            if (!Schema::hasColumn('inventory', 'id_item')) {
                $table->unsignedBigInteger('id_item')->nullable()->after('id_inventory');
                $table->index('id_item', 'inventory_id_item_index');
            }
        });
    }

    public function down(): void
    {
        Schema::table('inventory', function (Blueprint $table) {
            if (Schema::hasColumn('inventory', 'id_item')) {
                $table->dropIndex('inventory_id_item_index');
                $table->dropColumn('id_item');
            }
        });
    }
};
