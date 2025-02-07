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
        Schema::create('clusters', function (Blueprint $table) {
            $table->id('clusterId');
            $table->unsignedBigInteger('subhubId');
            $table->unsignedBigInteger('hospitalId');
            $table->string('clusterName')->nullable();
            $table->string('clusterCode')->nullable();
            $table->string('clusterType')->nullable();
            $table->string('status')->nullable();
            $table->unsignedBigInteger('stateId')->nullable();
        

            $table->foreign('subhubId')->references('subhubId')->on('subhubs');
            $table->foreign('stateId')->references('stateId')->on('states');
            $table->foreign('hospitalId')->references('hospitalId')->on('hospitals');
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
