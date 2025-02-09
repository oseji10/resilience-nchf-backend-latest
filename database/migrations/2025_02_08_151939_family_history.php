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
        Schema::create('patient_family_history', function (Blueprint $table) {
            $table->id('familyHistoryId');
            $table->unsignedBigInteger('patientUserId')->nullable();
            $table->string('familySetupSize')->nullable();
            $table->string('birthOrder')->nullable();
            $table->string('fathersEducationalLevel')->nullable();
            $table->string('mothersEducationalLevel')->nullable();
            $table->string('fathersOccupation')->nullable();
            $table->string('mothersOccupation')->nullable();
            $table->string('levelOfFamilyCare')->nullable();
            $table->string('familyMonthlyIncome')->nullable();
            $table->unsignedBigInteger('reviewerId')->nullable();
            $table->string('status')->nullable();
            $table->foreign('patientUserId')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('reviewerId')->references('id')->on('users')->onDelete('cascade');
            
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
