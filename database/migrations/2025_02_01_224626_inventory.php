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
        Schema :: create('inventory', function (Blueprint $table) {
            $table -> id('inventoryId');
            $table -> unsignedBigInteger('productId') -> nullable();
            $table -> string('batchNumber') -> nullable();
            $table -> string('expiryDate') -> nullable();
            $table -> string('inventoryType') -> nullable();
            $table -> string('quantityReceived') -> nullable();
            $table -> string('quantitySold') -> nullable();
            $table -> string('inventoryStatus') -> nullable();
            $table -> string('inventoryQuantityDamaged') -> nullable();
            $table -> string('inventoryQuantityReturned') -> nullable();
            $table -> string('inventoryQuantityExpired') -> nullable();
            $table -> unsignedBigInteger('uploadedBy') -> nullable();
            $table -> timestamps();

            $table->foreign('uploadedBy')->references('id')->on('users');
            $table->foreign('productId')->references('productId')->on('products');
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
