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
        Schema::create('patient_referral', function (Blueprint $table) {
            $table->id('referralId');
            $table->unsignedBigInteger('patientUserId')->nullable();
            $table->unsignedBigInteger('referringHospital')->nullable();
            $table->unsignedBigInteger('referredHospital')->nullable();
            $table->unsignedBigInteger('referringDoctor')->nullable();
            $table->unsignedBigInteger('referredDoctor')->nullable();
            $table->unsignedBigInteger('referringCMD')->nullable();
            $table->unsignedBigInteger('referredCMD')->nullable();
            $table->string('appointmentDate')->nullable();
            $table->text('referringDoctorComment')->nullable();
            $table->text('referredDoctorComment')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
      
            $table->foreign('patientUserId')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('referringHospital')->references('hospitalId')->on('hospitals')->onDelete('cascade');
            $table->foreign('referredHospital')->references('hospitalId')->on('hospitals')->onDelete('cascade');
            $table->foreign('referringDoctor')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('referredDoctor')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('referringCMD')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('referredCMD')->references('id')->on('users')->onDelete('cascade');
            
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
