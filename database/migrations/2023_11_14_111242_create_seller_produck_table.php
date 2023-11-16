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
        Schema::create('seller_produck', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sellerId');
            $table->integer('stock');
            $table->integer('price');
            $table->string('colors');
            $table->string("pruduckImage");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_produck');
    }
};
