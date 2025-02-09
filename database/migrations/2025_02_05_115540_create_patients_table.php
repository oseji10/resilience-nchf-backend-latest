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
            $table->string('nin')->nullable();
            $table->unsignedBigInteger('userId')->nullable();
            $table->string('chfId')->nullable()->unique();
            $table->string('hospitalFileNumber')->nullable();
            $table->unsignedBigInteger('hospital')->nullable();
            $table->unsignedBigInteger('stateOfOrigin')->nullable();
            $table->unsignedBigInteger('stateOfResidence')->nullable();
            $table->string('religion')->nullable();
            $table->string('gender')->nullable();
            $table->string('bloodGroup')->nullable();
            $table->string('occupation')->nullable();
            $table->date('dateOfBirth')->nullable();
            $table->string('address')->nullable();
            $table->string('nextOfKinName')->nullable();
            $table->string('nextOfKinAddress')->nullable();
            $table->string('nextOfKinPhoneNumber')->nullable();
            $table->string('nextOfKinEmail')->nullable();
            $table->string('nextOfKinRelationship')->nullable();
            $table->string('nextOfKinOccupation')->nullable();
            $table->string('nextOfKinGender')->nullable();
            $table->unsignedBigInteger('hmo')->nullable();
            $table->string('hmoNumber')->nullable();
            $table->unsignedBigInteger('cancer')->nullable();
            $table->unsignedBigInteger('doctor')->nullable();
            $table->string('status')->nullable();
            // $table->enum('status', ['application_in_progress', 'pending_doctor_review', 'doctor_approved', 'social_worker_approved', 'tumour_board_approved', 'cmd_approved', 'final_approval', 'rejected', 'disabled', 'deceased', 'cured',])->default('application_in_progress')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('doctor')->references('doctorId')->on('doctors')->onDelete('cascade');
            $table->foreign('hospital')->references('hospitalId')->on('hospitals')->onDelete('cascade');
            $table->foreign('stateOfOrigin')->references('stateId')->on('states')->onDelete('cascade');
           
            $table->foreign('stateOfResidence')->references('stateId')->on('states')->onDelete('cascade');
           
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('hmo')->references('hmoId')->on('hmos')->onDelete('cascade');
            $table->foreign('cancer')->references('cancerId')->on('cancers');
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
