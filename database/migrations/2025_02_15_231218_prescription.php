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
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prescriptionId')->unique();
            $table->unsignedBigInteger('patientId')->nullable();
            $table->unsignedBigInteger('hospitalId')->nullable();
            $table->string('comments')->nullable();
            $table->unsignedBigInteger('prescribedBy')->nullable();
            $table->timestamps();
            

           
            $table->foreign('patientId')->references('patientId')->on('patients')->onDelete('cascade');
            $table->foreign('hospitalId')->references('hospitalId')->on('hospitals')->onDelete('cascade');
            $table->foreign('prescribedBy')->references('id')->on('users')->onDelete('cascade');
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
