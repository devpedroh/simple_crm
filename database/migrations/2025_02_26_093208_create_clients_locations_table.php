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
        Schema::create('clients_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->index();
            $table->string('street');
            $table->string('number')->nullable();
            $table->string('complement')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients_locations');
    }
};
