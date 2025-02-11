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
        Schema::create('e_wallet_transactions', function (Blueprint $table) {
            $table->id('transactionId');
            $table->unsignedBigInteger('walletId')->nullable();
            $table->unsignedBigInteger('hospitalId')->nullable();
            $table->double('amount')->default(0.00)->nullable();
            $table->enum('transactionType', ['credit', 'debit'])->nullable();
            $table->string('reason')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('hospitalId')->references('hospitalId')->on('hospitals');
            $table->foreign('walletId')->references('walletId')->on('e_wallets');
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
