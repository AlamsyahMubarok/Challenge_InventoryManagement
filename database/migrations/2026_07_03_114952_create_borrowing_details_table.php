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
    Schema::create('borrowing_details', function (Blueprint $table) {
        $table->id();

        $table->foreignId('borrowing_id')
            ->constrained('borrowings')
            ->cascadeOnDelete();

        $table->foreignId('product_id')
            ->constrained('products')
            ->restrictOnDelete();

        $table->integer('quantity');
        $table->string('condition_before', 50)->nullable();
        $table->string('condition_after', 50)->nullable();
        $table->text('notes')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowing_details');
    }
};
