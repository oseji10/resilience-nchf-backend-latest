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
        Schema::create('patient_medical_history', function (Blueprint $table) {
            $table->id('medicalHistoryId');
            $table->unsignedBigInteger('patientUserId')->nullable();
            
            $table->unsignedBigInteger('hospitalId')->nullable();
            $table->string('history')->nullable();
            $table->unsignedBigInteger('addedBy')->nullable();
            $table->timestamps();
            

           
            $table->foreign('patientUserId')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('hospitalId')->references('hospitalId')->on('hospitals')->onDelete('cascade');
            $table->foreign('addedBy')->references('id')->on('users')->onDelete('cascade');
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
