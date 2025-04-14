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
        
        Schema::create('patient_transfer', function (Blueprint $table) {
            $table->id('transferId');
            $table->unsignedBigInteger('patientUserId')->nullable();
            $table->unsignedBigInteger('transferringHospital')->nullable();
            $table->unsignedBigInteger('transferredHospital')->nullable();
            $table->unsignedBigInteger('transferringDoctor')->nullable();
            $table->unsignedBigInteger('transferredDoctor')->nullable();
            $table->unsignedBigInteger('transferringCMD')->nullable();
            $table->unsignedBigInteger('transferredCMD')->nullable();
            $table->string('appointmentDate')->nullable();
            $table->text('transferringDoctorComment')->nullable();
            $table->text('transferredDoctorComment')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            

           
            $table->foreign('patientUserId')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('transferringHospital')->references('hospitalId')->on('hospitals')->onDelete('cascade');
            $table->foreign('transferredHospital')->references('hospitalId')->on('hospitals')->onDelete('cascade');
            $table->foreign('transferringDoctor')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('transferredDoctor')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('transferringCMD')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('transferredCMD')->references('id')->on('users')->onDelete('cascade');
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
