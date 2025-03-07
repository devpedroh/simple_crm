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
        Schema::create('sells_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sell_id')->index();
            $table->foreignId('product_id')->index();
            $table->foreignId('supplier_id')->index();
            $table->decimal('price', 14, 2)->default(0);
            $table->decimal('qtd', 14, 2);
            $table->decimal('total_price', 14, 2)->generatedAs('price * qtd');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sells_products');
    }
};
