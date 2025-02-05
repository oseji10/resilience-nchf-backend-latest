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
            $table->unsignedBigInteger('hubId');
            $table->unsignedBigInteger('hospitalId');
            $table->string('subhubName');
            $table->string('subhubType');
            $table->string('subhubCode');
            $table->string('status');
            $table->unsignedBigInteger('stateId');

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
