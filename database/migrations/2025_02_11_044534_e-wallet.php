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
        Schema::create('e_wallets', function (Blueprint $table) {
            $table->id('walletId');
            $table->unsignedBigInteger('hospitalId')->nullable();
            $table->double('balance')->default(0.00)->nullable();
            $table->string('comments')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('hospitalId')->references('hospitalId')->on('hospitals')->onDelete('cascade');
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
