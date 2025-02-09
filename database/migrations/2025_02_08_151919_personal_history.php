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
        Schema::create('patient_personal_history', function (Blueprint $table) {
            $table->id('personalHistoryId');
            $table->unsignedBigInteger('patientUserId')->nullable();
            $table->string('averageMonthlyIncome')->nullable();
            $table->string('averageFeedingDaily')->nullable();
            $table->string('whoProvidesFeeding')->nullable();
            $table->string('accomodation')->nullable();
            $table->string('typeOfAccomodation')->nullable();
            $table->string('noOfGoodSetOfClothes')->nullable();
            $table->string('howAreClothesGotten')->nullable();
            $table->text('whyDidYouChooseHospital')->nullable();
            $table->unsignedBigInteger('hospitalReceivingCare')->nullable();
            $table->string('levelOfSpousalSpupport')->nullable();
            $table->string('otherSupport')->nullable();
            $table->unsignedBigInteger('reviewerId')->nullable();
            $table->string('status')->nullable();
            $table->foreign('patientUserId')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('reviewerId')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('hospitalReceivingCare')->references('hospitalId')->on('hospitals')->onDelete('cascade');
            
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
