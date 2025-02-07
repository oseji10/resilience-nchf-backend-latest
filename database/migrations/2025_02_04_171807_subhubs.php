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
       Schema::create('subhubs', function (Blueprint $table) {
            $table->id('subhubId');
            $table->unsignedBigInteger('hubId')->nullable();
            $table->unsignedBigInteger('hospitalId')->nullable();
            $table->string('subhubName')->nullable();
            $table->string('subhubType')->nullable();
            $table->string('subhubCode')->nullable();
            $table->string('status')->nullable();
            $table->unsignedBigInteger('stateId')->nullable();

            $table->foreign('hubId')->references('hubId')->on('hubs');
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
