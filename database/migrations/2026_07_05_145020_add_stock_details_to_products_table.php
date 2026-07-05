<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (! Schema::hasColumn('products', 'description')) {
                $table->text('description')->nullable();
            }

            if (! Schema::hasColumn('products', 'minimum_stock')) {
                $table->integer('minimum_stock')->default(5);
            }

            if (! Schema::hasColumn('products', 'light_damage_stock')) {
                $table->integer('light_damage_stock')->default(0);
            }

            if (! Schema::hasColumn('products', 'heavy_damage_stock')) {
                $table->integer('heavy_damage_stock')->default(0);
            }

            if (! Schema::hasColumn('products', 'maintenance_stock')) {
                $table->integer('maintenance_stock')->default(0);
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'description')) {
                $table->dropColumn('description');
            }

            if (Schema::hasColumn('products', 'minimum_stock')) {
                $table->dropColumn('minimum_stock');
            }

            if (Schema::hasColumn('products', 'light_damage_stock')) {
                $table->dropColumn('light_damage_stock');
            }

            if (Schema::hasColumn('products', 'heavy_damage_stock')) {
                $table->dropColumn('heavy_damage_stock');
            }

            if (Schema::hasColumn('products', 'maintenance_stock')) {
                $table->dropColumn('maintenance_stock');
            }
        });
    }
};
