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
        Schema::create('services', function (Blueprint $table) {
            $table->id('serviceId');
            $table->string('serviceName')->nullable();
            $table->string('serviceDescription')->nullable();
            $table->string('serviceType')->nullable();
            $table->string('serviceCategory')->nullable();
            $table->string('serviceCost')->nullable();
            $table->string('servicePrice')->nullable();
            $table->string('serviceStatus')->nullable();
            $table->unsignedBigInteger('uploadedBy')->nullable();
            $table->timestamps();

            $table->foreign('uploadedBy')->references('id')->on('users');
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
