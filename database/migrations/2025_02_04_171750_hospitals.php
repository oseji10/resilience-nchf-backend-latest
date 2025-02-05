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
            $table->text('address');
            $table->string('phone');
            $table->string('email');
            $table->string('website');
            $table->unsignedBigInteger('stateId');
            $table->string('hospitalCode');
            $table->string('hospitalType');
            $table->unsignedBigInteger('hospitalAdmin');
            $table->unsignedBigInteger('hospitalCMD');
            $table->string('status');

         
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
