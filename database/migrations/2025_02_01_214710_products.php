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
            $table->id('productId');
            $table->string('productName')->nullable();
            $table->string('productDescription')->nullable();
            $table->string('productType')->nullable();
            $table->string('productCategory')->nullable();
            $table->string('productQuantity')->nullable();
            $table->string('productCost')->nullable();
            $table->string('productPrice')->nullable();
            $table->string('productStatus')->nullable();
            $table->string('productImage')->nullable();
            $table->string('productManufacturer')->nullable();
            $table->unsignedBigInteger('uploadedBy')->nullable();
            $table->timestamps();

            $table->foreign('uploadedBy')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
