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
        Schema::create('states', function (Blueprint $table) {
            $table->id('stateId');
            $table->unsignedBigInteger('zoneId');
            $table->string('stateName');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('zoneId')->references('zoneId')->on('geopolitical_zones');
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
