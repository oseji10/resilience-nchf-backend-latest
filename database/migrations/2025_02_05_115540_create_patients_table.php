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
        Schema::create('patients', function (Blueprint $table) {
            $table->id('patientId');
            $table->string('NIN')->nullable();
            $table->unsignedBigInteger('userId')->nullable();
            $table->string('chfId')->nullable()->unique();
            $table->string('hospitalFileNumber')->nullable();
            $table->unsignedBigInteger('hospital')->nullable();
            $table->unsignedBigInteger('stateOfOrigin')->nullable();
            $table->unsignedBigInteger('lgaOfOrigin')->nullable();
            $table->unsignedBigInteger('stateOfResidence')->nullable();
            $table->unsignedBigInteger('lgaOfResidence')->nullable();
            $table->string('phoneNumber')->nullable();
            $table->string('email')->nullable();
            $table->string('gender')->nullable();
            $table->string('bloodGroup')->nullable();
            $table->string('occupation')->nullable();
            $table->date('dateOfBirth')->nullable();
            $table->string('address')->nullable();
            $table->string('nextOfKin')->nullable();
            $table->string('nextOfKinAddress')->nullable();
            $table->string('nextOfKinPhoneNumber')->nullable();
            $table->string('nextOfKinEmail')->nullable();
            $table->string('nextOfKinRelationship')->nullable();
            $table->string('nextOfKinOccupation')->nullable();
            $table->string('nextOfKinGender')->nullable();
            $table->unsignedBigInteger('hmoId')->nullable();
            $table->unsignedBigInteger('cancerType')->nullable();
            $table->unsignedBigInteger('doctor')->nullable();
            $table->enum('status', ['active', 'disabled', 'deceased', 'cured'])->default('active')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('doctor')->references('doctorId')->on('doctors')->onDelete('cascade');
            $table->foreign('hospital')->references('hospitalId')->on('hospitals')->onDelete('cascade');
            $table->foreign('stateOfOrigin')->references('stateId')->on('states')->onDelete('cascade');
            $table->foreign('lgaOfResidence')->references('lgaId')->on('lgas')->onDelete('cascade');
            $table->foreign('stateOfResidence')->references('stateId')->on('states')->onDelete('cascade');
            $table->foreign('lgaOfOrigin')->references('lgaId')->on('lgas')->onDelete('cascade');
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('hmoId')->references('hmoId')->on('hmos')->onDelete('cascade');
            $table->foreign('cancerType')->references('cancerId')->on('cancers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
