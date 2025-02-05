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
        Schema::create('billings', function (Blueprint $table) {
            $table->id('billingId');
            $table->string('transactionId')->nullable();
            $table->unsignedBigInteger('patientId')->nullable();
            $table->string('billingType')->nullable();
            $table->string('categoryType')->nullable();
            $table->unsignedBigInteger('inventoryId')->nullable();
            $table->unsignedBigInteger('productId')->nullable();
            $table->unsignedBigInteger('serviceId')->nullable();
            $table->string('cost')->nullable();
            $table->string('quantity')->nullable();
            $table->string('paymentMethod')->nullable();
            $table->string('paymentStatus')->nullable();
            $table->string('paymentReference')->nullable();
            $table->string('paymentDate')->nullable();
            $table->string('status')->nullable();
            $table->text('comments')->nullable();
            $table->unsignedBigInteger('hospitalId')->nullable();
            $table->unsignedBigInteger('billedBy')->nullable();
            $table->timestamps();

            $table->foreign('patientId')->references('patientId')->on('patients');
            $table->foreign('billedBy')->references('id')->on('users');
            $table->foreign('inventoryId')->references('inventoryId')->on('inventory');
            $table->foreign('productId')->references('productId')->on('products');
            $table->foreign('serviceId')->references('serviceId')->on('services');
            $table->foreign('hospitalId')->references('hospitalId')->on('hospitals');
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
