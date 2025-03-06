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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 14, 2)->nullable()->default(0.00);
            $table->decimal('weight', 14, 2)->nullable();
            $table->foreignId('weight_unit_id')->index()->nullable();
            $table->decimal('width', 14, 2)->nullable();
            $table->foreignId('width_unit_id')->index()->nullable();
            $table->decimal('length', 14, 2)->nullable();
            $table->foreignId('length_unit_id')->index()->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
