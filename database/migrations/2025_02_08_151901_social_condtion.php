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
        Schema::create('patient_social_condition', function (Blueprint $table) {
            $table->id('socialConditionId');
            $table->unsignedBigInteger('patientUserId')->nullable();
            $table->string('runningWater')->nullable();
            $table->string('toiletType')->nullable();
            $table->string('powerSupply')->nullable();
            $table->string('meansOfTransport')->nullable();
            $table->string('mobilePhone')->nullable();
            $table->string('howPhoneIsRecharged')->nullable();
            $table->string('status')->nullable();
            
            $table->unsignedBigInteger('reviewerId')->nullable();

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
