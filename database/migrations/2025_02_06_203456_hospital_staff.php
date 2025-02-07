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
        Schema::create('hospital_staff', function (Blueprint $table) {
            $table->id('hospitalStaffId');
            $table->unsignedBigInteger('userId')->nullable();
            $table->unsignedBigInteger('hospitalId')->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
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
