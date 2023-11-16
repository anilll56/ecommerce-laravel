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
        Schema::create('buy_order', function (Blueprint $table) {
            $table->id();
            $table->string('buyerId');
            $table->string('sellerId');
            $table->string('produckId');
            $table->string('produckName');
            $table->integer('produckPrice');
            $table->string('produckImage');
            $table->string('produckColor');
            $table->integer('produckPieces');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buy_order');
    }
};
