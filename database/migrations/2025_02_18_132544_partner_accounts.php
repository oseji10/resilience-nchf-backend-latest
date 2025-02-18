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
        Schema::create('hospital_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hospitalId')->unique();
            $table->string('accountName')->nullable();
            $table->string('accountNumber')->nullable();
            $table->string('bankName')->nullable();
            $table->string('sortCode')->nullable();
            $table->unsignedBigInteger('addedBy')->nullable();
            $table->timestamps();
            

           
          
            $table->foreign('hospitalId')->references('hospitalId')->on('hospitals')->onDelete('cascade');
            $table->foreign('addedBy')->references('id')->on('users')->onDelete('cascade');
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
