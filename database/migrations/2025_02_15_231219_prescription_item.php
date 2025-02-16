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
        Schema::create('prescription_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prescriptionId')->nullable();
            
            
            $table->string('type')->nullable();
            $table->unsignedBigInteger('productId')->nullable();
            $table->unsignedBigInteger('serviceId')->nullable();
            $table->string('quantity')->nullable();
            
            $table->timestamps();
            

            $table->foreign('productId')->references('productId')->on('products')->onDelete('cascade');
            $table->foreign('serviceId')->references('serviceId')->on('services')->onDelete('cascade');
            $table->foreign('prescriptionId')->references('prescriptionId')->on('prescriptions')->onDelete('cascade');
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
