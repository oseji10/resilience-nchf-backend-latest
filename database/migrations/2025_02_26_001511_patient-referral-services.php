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
        Schema::create('patient_referral_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patientUserId')->nullable();
            $table->unsignedBigInteger('hospitalId')->nullable();
            $table->unsignedBigInteger('serviceId')->nullable();
            $table->unsignedBigInteger('referralId')->nullable();
            $table->string('comment')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            
            $table->foreign('patientUserId')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('hospitalId')->references('hospitalId')->on('hospitals')->onDelete('cascade');
            $table->foreign('serviceId')->references('serviceId')->on('services')->onDelete('cascade');
            $table->foreign('referralId')->references('referralId')->on('patient_referral')->onDelete('cascade');
            
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
