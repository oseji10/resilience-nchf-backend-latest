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
        Schema::create('pool', function (Blueprint $table) {
            $table->id('walletId');
            $table->double('balance')->default(0.00)->nullable();
            $table->string('comments')->nullable();
            $table->unsignedBigInteger('createdBy')->nullable();
            $table->unsignedBigInteger('lastUpdatedBy')->nullable();
            $table->timestamps();
            $table->softDeletes();

            
            $table->foreign('createdBy')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('lastUpdatedBy')->references('id')->on('users')->onDelete('cascade');
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
