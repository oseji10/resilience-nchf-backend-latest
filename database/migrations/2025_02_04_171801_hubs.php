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
        Schema::create('hubs', function (Blueprint $table) {
            $table->id('hubId');
            $table->unsignedBigInteger('hospitalId');
            $table->string('hubName')->nullable();
            $table->string('hubCode')->nullable();
            $table->string('hubType')->nullable();
            $table->string('status')->nullable();
            $table->unsignedBigInteger('stateId')->nullable();
            
            $table->foreign('hospitalId')->references('hospitalId')->on('hospitals');
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
