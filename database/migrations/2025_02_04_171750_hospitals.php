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
        Schema::create('hospitals', function (Blueprint $table) {
            $table->id('hospitalId');
            $table->string('hospitalName');
            $table->string('hospitalShortName');
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->unsignedBigInteger('stateId')->nullable();
            $table->string('hospitalCode')->nullable();
            $table->string('hospitalType')->nullable();
            $table->unsignedBigInteger('hospitalAdmin')->nullable();
            $table->unsignedBigInteger('hospitalCMD')->nullable();
            $table->string('status')->nullable();

         
            $table->foreign('hospitalAdmin')->references('id')->on('users');
            $table->foreign('hospitalCMD')->references('id')->on('users');
            $table->foreign('stateId')->references('stateId')->on('states');

            $table->timestamps();
            $table->softDeletes();
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
